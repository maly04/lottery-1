<?php namespace App\Model\Relations\Decorators;

class HasManyDecorator extends RelationDecorator {
	
	/**
     * Get a new pivot statement for a given "other" ID.
     *
     * @param  mixed  $id
     * @return \Illuminate\Database\Query\Builder
     */
    public function newPivotStatementForId($id)
    {
        return $this->relation->getRelated()->newQuery()->where($this->getOtherRelatedKey(), $id);
    }
	
	function getCurrents($id = null) {
		return $this->newPivotStatement()->where('deleted_at', null)->pluck($this->relation->getRelated()->getKeyName()) ;		
	}
	
	function newPivotStatement() {
		return $this->relation->getBaseQuery();
	}
	
	function getOtherRelatedKey() {
		return $this->relation->getRelated()->getKeyName();
	}
	
	function getRelatedSqlForId($id) {
		return $this->relation->getRelated()->newQuery()->where($this->relation->getRelated()->getKeyName(), $id);
	}
	
	 /**
     * Update an existing pivot record on the table.
     *
     * @param  mixed  $id
     * @param  array  $attributes
     * @param  bool   $touch
     * @return int
     */
    public function updateExistingPivot($id, array $attributes, $touch = true)
    {
        $attributes = $this->setTimestampsOnAttach($attributes, true);
		$updated = $this->getRelatedSqlForId($id)->withTrashed()->update($attributes);
		
        return $updated;
    }
	
	 /**
     * Attach a model to the parent.
     *
     * @param  mixed  $id
     * @param  array  $attributes
     * @param  bool   $touch
     * @return void
     */
    function attach($id, array $attributes = [])
    {
		
        if ($id instanceof Model) {
            $id = $id->getKey();
        }

        if ($id instanceof Collection) {
            $id = $id->modelKeys();
        }

        $query = $this->newPivotStatement();
        $query->insert($this->createAttachRecords((array) $id, $attributes));
    }
	
	/**
     * Create an array of records to insert into the pivot table.
     *
     * @param  array  $ids
     * @param  array  $attributes
     * @return array
     */
    protected function createAttachRecords($ids, array $attributes, array $timed = array())
    {
        $records = [];

        // To create the attachment records, we will simply spin through the IDs given
        // and create a new record to insert for each ID. Each ID may actually be a
        // key in the array, with extra attributes to be placed in other columns.
        foreach ($ids as $key => $value) {
            $records[] = $this->attacher($key, $value, $attributes, $timed);
        }

        return $records;
    }
	
	/**
     * Create a full attachment record payload.
     *
     * @param  int    $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @param  bool   $timed
     * @return array
     */
    protected function attacher($key, $value, $attributes, $timed)
    {
        list($id, $extra) = $this->getAttachId($key, $value, $attributes);

        // To create the attachment records, we will simply spin through the IDs given
        // and create a new record to insert for each ID. Each ID may actually be a
        // key in the array, with extra attributes to be placed in other columns.
        $record = $this->createAttachRecord($id, $timed);

        return array_merge($record, $extra);
    }
	
	/**
     * Get the attach record ID and extra attributes.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    protected function getAttachId($key, $value, array $attributes)
    {
        if (is_array($value)) {
            return [$key, array_merge($value, $attributes)];
        }

        return [$value, $attributes];
    }
	
	 /**
     * Create a new pivot attachment record.
     *
     * @param  int   $id
     * @param  bool  $timed
     * @return array
     */
    protected function createAttachRecord($id, $timed)
    {
        $record[$this->getOtherRelatedKey()] = $id;

        // If the record needs to have creation and update timestamps, we will make
        // them by calling the parent model's "freshTimestamp" method which will
        // provide us with a fresh timestamp in this model's preferred format.
        if ($timed) {
            $record = $this->setTimestampsOnAttach($record);
        }

        return $record;
    }
	
	/**
     * Set the creation and update timestamps on an attach record.
     *
     * @param  array  $record
     * @param  bool   $exists
     * @return array
     */
    protected function setTimestampsOnAttach(array $record, $exists = false)
    {
        $fresh = $this->relation->getParent()->freshTimestamp();

		$record[$this->relation->createdAt()] = $fresh;
		$record[$this->relation->updatedAt()] = $fresh;

        return $record;
    }
	
}