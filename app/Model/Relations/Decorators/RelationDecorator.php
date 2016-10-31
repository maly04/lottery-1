<?php namespace App\Model\Relations\Decorators;

use Illuminate\Database\Eloquent\Relations\Relation;
use App\Helpers\ArrayJsonHelper;
use Illuminate\Database\Eloquent\Model;

abstract class RelationDecorator {
	
	protected $relation;
	
	protected $entity;
	
	private $user;
	
	private $isPivot;
	
	private $isPrimary;
	
	public function __construct(Relation $relation, Model $entity, $isPivot = false, $isPrimary = false) {
		$this->relation = $relation;
		
		$this->user = new \StdClass;
		$this->user->id = null;
		
		$this->entity = $entity;
		$this->isPivot = $isPivot;
		$this->isPrimary = $isPrimary;
	}
	
	abstract function getCurrents($id = null);
	
	abstract function newPivotStatement();
	
	abstract function getOtherRelatedKey();
	
	abstract function updateExistingPivot($id, array $attributes, $touch = true);
	
	/**
     * Get a new pivot statement for a given "other" ID.
     *
     * @param  mixed  $id
     * @return \Illuminate\Database\Query\Builder
     */
    public function newPivotStatementForId($id)
    {
        return $this->newPivotQuery()->where($this->getOtherRelatedKey(), $id);
    }
	
	/**
     * Create a new query builder for the pivot table.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newPivotQuery()
    {
        $query = $this->newPivotStatement();
        return $query->where($this->relation->getForeignKey(), $this->relation->getParent()->getKey());
    }
	
	public function syncCollection($fieldValue) {
		
		$collection = is_array($fieldValue) ? $fieldValue : ArrayJsonHelper::parseStringToArray($fieldValue);
		
		$records = $this->formatSyncList($collection);
		
		$current = $this->getCurrents($this->entity->id);
		
		$detach = array_diff($current, array_keys($records));
		
		$this->detach($detach, $this->relation);
		
		$this->attachNew($records, $current, $this->relation);
		
		return $records;
	}
	
	public function detach(array $ids = []) {
		foreach($ids as $id) {
			$query = $this->newPivotStatementForId($id);
			
			if($this->isPivot) {
				
				$attributes[$this->relation->getParent()->getForeignKey()] = null;
				$query->update($attributes);
				
			} else {
				
				try {
					$query->update(['deleted_by' => $this->user->id, 'deleted_at' => date('Y-m-d H:i:s')]);
				} catch (\Exception $e) {
					
					$query->delete();
				}
				
			}
			
		}
    }
	
	public function attachNew(array $records, array $current) {
		
        foreach ($records as $id => $attributes) {
			
			if (! in_array($id, $current)) {
				if($this->isPivot) {
					
					$attributes[$this->relation->getParent()->getForeignKey()] = $this->entity->id;
					
					$this->updateExistingPivot($id, $attributes);
					
				} else {
					
					$attributes[$this->relation->getParent()->getKeyName()] = $this->entity->getId();
					
					$attributes[$this->relation->getRelated()->getKeyName()] = $id;
					
					$query = $this->newPivotStatement();
					$query->insert($attributes);
					
					if(method_exists($this->relation->getRelated(), 'afterInserted')) {
						$this->relation->getRelated()->afterInserted();
					}
				}
                
            } else {
				$this->updateExistingPivot($id, $attributes);
			}
        }
    }
	
	public function __call($method, $parameters) {
		return call_user_func_array(array($this->relation, $method), $parameters);
	}
	
	/**
     * Format the sync list so that it is keyed by ID.
     *
     * @param  array  $records
     * @return array
     */
    protected function formatSyncList(array $records) {
        $results = [];
		
        foreach ($records as $id => $attributes) {
		
			if (! is_array($attributes)) {
				list($id, $attributes) = [$attributes, []];
			}

			$results[$id] = $attributes;
        }

        return $results;
    }
}