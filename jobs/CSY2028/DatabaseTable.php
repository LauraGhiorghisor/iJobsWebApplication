<?php

namespace CSY2028;

class DatabaseTable
{

	private $pdo;
	private $table;
	private $primaryKey;
	private $entityClass;
	private $entityConstructor;

	//class constructor
	public function __construct($pdo, $table, $primaryKey, $entityClass = 'stdclass', $entityConstructor = [])
	{
		$this->pdo = $pdo;
		$this->table = $table;
		$this->primaryKey = $primaryKey;
		$this->entityClass = $entityClass;
		$this->entityConstructor = $entityConstructor;
	}

	//find a record based on a given field and value
	public function find($field, $value)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = :value');
		$criteria = [
			'value' => $value
		];
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute($criteria);
		return $stmt->fetchAll();
	}

	//advanced version of the find, uses 3 criteria, one with comparison
	public function find_3_cond($field1, $val1, $field2, $val2, $field3, $val3)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field1 . ' = :value1 AND ' . $field2 . ' =:value2 AND ' . $field3 . ' >:value3');
		$criteria = [
			'value1' => $val1,
			'value2' => $val2,
			'value3' => $val3
		];
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute($criteria);
		return $stmt->fetchAll();
	}

	// advanced version of the find method
	public function find_3_equal_cond($field1, $val1, $field2, $val2, $field3, $val3)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field1 . ' = :value1 AND ' . $field2 . ' =:value2 AND ' . $field3 . ' =:value3');
		$criteria = [
			'value1' => $val1,
			'value2' => $val2,
			'value3' => $val3
		];
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute($criteria);
		return $stmt->fetchAll();
	}

	// advanced version of the find, uses 2 criteria
	public function find_2_cond($field1, $val1, $field2, $val2)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field1 . ' LIKE :value1 AND ' . $field2 . ' LIKE :value2');
		$criteria = [
			'value1' => $val1,
			'value2' => $val2
		];
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute($criteria);
		return $stmt->fetchAll();
	}

	//advanced version of the find, generates a selected of 10 records sorted and ordered
	public function find_order_limit_date_archive($field1, $field2, $val2, $orderField, $orderDirection, $limit)
	{
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $field1 . ' > SYSDATE() AND ' . $field2 . ' =:val2 ORDER BY ' . $orderField . ' ' . $orderDirection . ' LIMIT ' . $limit);
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$criteria = [
			'val2' => $val2
		];
		$stmt->execute($criteria);
		return $stmt->fetchAll();
	}

	// returns all records
	public function findAll()
	{
		$stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	// inserts record
	public function insert($record)
	{
		$keys = array_keys($record);
		$values = implode(', ', $keys);
		$valuesWithColon = implode(', :', $keys);
		$query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($record);
	}

	// deletes record of a given primary key column value
	public function delete($id)
	{
		$stmt = $this->pdo->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id');
		$criteria = [
			'id' => $id
		];
		$stmt->execute($criteria);
	}

	// uses an archived_status column to archive a record
	public function archive($id)
	{
		$stmt = $this->pdo->prepare('UPDATE ' . $this->table . ' SET archived_status = \'Yes\' WHERE ' . $this->primaryKey . '= :id');
		$criteria = [
			'id' => $id
		];
		$stmt->execute($criteria);
	}

	//disables the archived status
	public function repost($id)
	{
		$stmt = $this->pdo->prepare('UPDATE ' . $this->table . ' SET archived_status = \'No\' WHERE ' . $this->primaryKey . '= :id');
		$criteria = [
			'id' => $id
		];
		$stmt->execute($criteria);
	}

	// returns all records from a table, but no double entries.
	public function selectDistinct($field)
	{
		$stmt = $this->pdo->prepare('SELECT DISTINCT ' . $field . ' FROM ' . $this->table);
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute();
		return $stmt->fetchAll();
	}

	// saves a record: if it cannot be inserted due to sql integrity constraint violation (existing PK value entry), it updates instead.
	public function save($record)
	{
		try {
			$this->insert($record);
		} catch (\PDOException $e) {
			$this->update($record);
		}
	}

	// updates a record
	public function update($record)
	{

		$query = 'UPDATE ' . $this->table . ' SET ';

		$parameters = [];
		foreach ($record as $key => $value) {
			$parameters[] = $key . ' = :' . $key;
		}

		$query .= implode(', ', $parameters);
		$query .= ' WHERE ' . $this->primaryKey . ' = :primaryKey';
		$record['primaryKey'] = $record[$this->primaryKey];
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($record);
	}

	// updates a specific field 
	public function update_field($field, $value, $id)
	{
		$stmt = $this->pdo->prepare('UPDATE ' . $this->table . ' SET ' . $field . ' = :value WHERE ' . $this->primaryKey . ' = :id');
		$criteria = [
			'value' => $value,
			'id' => $id
		];
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
		$stmt->execute($criteria);
	}
}
