<?php namespace App\Support\Decorators\Database;

use App\Model\Relations\Decorators\BelongsToManyDecorator;
use App\Model\Relations\Decorators\HasManyDecorator;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation as BaseRelation;
use Illuminate\Database\Eloquent\Collection;

class RelationMaker extends BaseRelation {
	
	private $relation;
	
	public function __construct(BaseRelation $relation, Model $model, $isPivot = false, $isPrimary = false) {
		
		if($relation instanceof BelongsToMany) {
			$this->relation = new BelongsToManyDecorator($relation, $model, $isPivot, $isPrimary);
		} else if($relation instanceof HasMany) {
			$this->relation = new HasManyDecorator($relation, $model, $isPivot, $isPrimary);
		}
	}
	
	/**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints(){
		return $this->relation->addConstraints();
	}

    /**
     * Set the constraints for an eager load of the relation.
     *
     * @param  array  $models
     * @return void
     */
    public function addEagerConstraints(array $models) {
		return $this->relation->addEagerConstraints($models);
	}

    /**
     * Initialize the relation on a set of models.
     *
     * @param  array   $models
     * @param  string  $relation
     * @return array
     */
    public function initRelation(array $models, $relation) {
		return $this->relation->initRelation($models, $relation);
	}

    /**
     * Match the eagerly loaded results to their parents.
     *
     * @param  array   $models
     * @param  \Illuminate\Database\Eloquent\Collection  $results
     * @param  string  $relation
     * @return array
     */
    public function match(array $models, Collection $results, $relation){
		return $this->relation->match($models, $results, $relation);
	}

    /**
     * Get the results of the relationship.
     *
     * @return mixed
     */
    public function getResults(){
		return $this->relation->getResults();
	}

	public function sync(array $with) {
		return $this->relation->syncCollection($with);
	}
	
	public function __call($method, $params){
		return call_user_func_array(array($this->relation, $method), $params);
	}
}