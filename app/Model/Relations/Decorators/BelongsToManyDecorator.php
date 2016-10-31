<?php namespace App\Model\Relations\Decorators;

use Schema;


class BelongsToManyDecorator extends RelationDecorator {
	
	const DELETED_AT = 'deleted_at';
	
	function getCurrents($id = null) {
		$query = $this->relation->newPivotStatement()->where($this->relation->getParent()->getKeyName(), $this->entity->getId());
		
		if($this->isModelHasDeletedAtField()) {
			$query = $query->where(static::DELETED_AT, null);
		}
		
		return $query->pluck($this->relation->getOtherKey())->toArray();
	}
	
	function newPivotStatement() {
		return $this->relation->newPivotStatement();
	}
	
	function updateExistingPivot($id, array $attributes, $touch = true) {
		
		if(count($attributes) > 0) {
			return $this->relation->updateExistingPivot($id, $attributes, $touch);
		}
		
		return null;
	}
	
	function getOtherRelatedKey() {
		return $this->relation->getOtherKey();
	}
	
	function getRelatedKey() {
		return $this->relation->getOtherKey();
	}
	
	function isModelHasDeletedAtField() {
		return Schema::hasColumn($this->relation->getTable(), static::DELETED_AT);
	}
}