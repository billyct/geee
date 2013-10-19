<?php

namespace Gee;

class Mongo {
	
	/**
	 *  静态成品变量 保存全局实例
	 *  @access private
	 */
	static private $_instance = NULL;
	
	private $_db = null;
	private $_conn = null;
	/**
	 *  私有化构造函数，防止外界实例化对象
	 */
	private function __construct() {
		try {
			$this->_conn = new \Mongo(MONGO_HOST);
			$this->_db = $this->_conn->{MONGO_DB};
		} catch ( \MongoConnectionException $e ) {
			$resultback = array('error' => 'Error connecting to MongoDB server');
            $resultback = json_encode($resultback);
			die($resultback);
		}
		
	}

	
	/**
	 *  私有化克隆函数，防止外界克隆对象
	 */
	private function __clone(){}
	/**
	 *  静态方法, 单例统一访问入口
	 *  @return  object  返回对象的唯一实例
	 */
	static public function getInstance() {
		if (is_null(self::$_instance) || !isset(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	/**
	 * Create (insert)
	 */
	public function create($collection, $document) {
		try {
			$collection = $this->_db->{$collection};
			$collection->insert ( $document );
			$this->_conn->close ();
			
			$document ['_id'] = $document ['_id']->{'$id'};
			
			return $document;
		} catch ( \MongoException $e ) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}
	}
	
	/**
	 * Read (findOne)
	 */
	public function read($collection, $id) {
		try {
			$collection = $this->_db->{$collection};
			
			$criteria = array (
					'_id' => new \MongoId ( $id ) 
			);
			
			$document = $collection->findOne ( $criteria );
			$this->_conn->close ();
			
			$document ['_id'] = $document ['_id']->{'$id'};
			
			return $document;
		} catch ( \MongoException $e ) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}
	}
	
	/**
	 * Update (set properties)
	 */
	public function updateSet($collection, $id, $document) {
		try {
			$collection = $this->_db->{$collection};
			
			$criteria = array (
					'_id' => new \MongoId ( $id ) 
			);
			
			// make sure that an _id never gets through
			unset ( $document ['_id'] );
			
			$collection->update ( $criteria, array (
					'$set' => $document 
			) );
			$this->_conn->close ();
			
			$document ['_id'] = $id;
			
			return $document;
		} catch ( \MongoException $e ) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}
	}

	/**
	 * update ($push properties)
	 */
	public function updatePush($collection, $id, $document) {
		try {
			$collection = $this->_db->{$collection};
			
			$criteria = array (
					'_id' => new \MongoId ( $id ) 
			);
			
			// make sure that an _id never gets through
			unset ( $document ['_id'] );
			
			$collection->update ( $criteria, array (
					'$push' => $document 
			) );
			$this->_conn->close ();
			
			$document ['_id'] = $id;
			
			return $document;
		} catch ( \MongoException $e ) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}
	}

	/**
	 * update (none properties)
	 */
	public function update($collection, $id, $document) {
		try {
			$collection = $this->_db->{$collection};
			
			$criteria = array (
					'_id' => new \MongoId ( $id ) 
			);
			
			// make sure that an _id never gets through
			unset ( $document ['_id'] );
			
			$collection->update ( $criteria, $document );
			$this->_conn->close ();
			
			$document ['_id'] = $id;
			
			return $document;
		} catch ( \MongoException $e ) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}
	}
	
	/**
	 * Delete (remove)
	 */
	public function delete($collection, $id) {
		try {
			$collection = $this->_db->{$collection};
			$criteria = array (
					'_id' => new \MongoId ( $id ) 
			);
			$collection->remove ( $criteria, array (
					'safe' => true 
			) );
			$this->_conn->close ();
			
			return array (
					'success' => 'deleted' 
			);
		} catch ( \MongoException $e ) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}
	}
	
	
	/**
	 * find one Collection  
	 **/
	public function findOne($collection, $select, $flag = false) {
		try {
			$collection = $this->_db->{$collection};
			$document = $collection->findOne($select);

			if ($flag) {
				$document = $this->getRefDouble($document);
			}
			
			if ($document) {
				$document ['_id'] = $document ['_id']->{'$id'};
			}
			$this->_conn->close ();
			return $document;
		} catch (\MongoException $e) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}	
	}


	private function getRefDouble($document) {

		foreach ($document as $key => $value) {
			if (!empty($value)) {
				if (\MongoDBRef::isRef($value)) {
					$document[$key] = $this->_db->getDBRef($value);
					if ($document[$key]) {
						$document[$key]['_id'] = $document[$key]['_id']->{'$id'};
					}
					
				}
				
				if (is_array($value) && !\MongoDBRef::isRef($value)) {
					$document[$key] = $this->getRefDouble($value);
				}
			}
			
		}
		

		return $document;
	}


	/*
	* find the refs from document
	*/
	public function getRefs($document, $ref) {
		try {
			$refs = array();
			foreach ($document[$ref] as $r) {
				$d = $this->_db->getDBRef($r);
				$d['_id'] = $d['_id']->{'$id'};
				$refs[] = $d;
			}
			$this->_conn->close ();

			return $refs;
		} catch (\MongoException $e) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}	
	}

	public function getRef($document, $ref) {
		try {
			$r = $this->_db->getDBRef($document[$ref]);
			if ($r) {
				$r ['_id'] = $r ['_id']->{'$id'};
			}
			$this->_conn->close ();
			return $r;
		} catch (\MongoException $e) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}	
	}
	
	
	/**
	 * Collection count
	 */
	
	function mongoCollectionCount($collection, $query = null) {
	
		try {
			$collection = $this->_db->{$collection};
	
			if($query) {
				return $collection->count($query);
			} else {
				return $collection->count();
			}
	
		} catch (\MongoException $e) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}
	
	}
	
	/**
	 * Mongo list with sorting and filtering
	 *
	 *  $select = array(
	 *    'limit' => 0,
	 *    'page' => 0,
	 *    'filter' => array(
	 *      'field_name' => 'exact match'
	 *    ),
	 *    'regex' => array(
	 *      'field_name' => '/expression/i'
	 *    ),
	 *    'sort' => array(
	 *      'field_name' => -1
	 *    )
	 *  );
	 */
	
	function mongoList($collection, $select = null, $flag = false) {
	
		try {
	
			$collection = $this->_db->{$collection};
	
			$criteria = NULL;
	
			// add exact match filters if they exist
	
			if(isset($select['filter']) && count($select['filter'])) {
				$criteria = $select['filter'];
			}
	
			// add regex match filters if they exist
	
			if(isset($select['wildcard']) && count($select['wildcard'])) {
				foreach($select['wildcard'] as $key => $value) {
					$criteria[$key] = new \MongoRegex($value);
				}
			}
	
			// get results
	
			if($criteria) {
				$cursor = $collection->find($criteria);
			} else {
				$cursor = $collection->find();
			}
	
			// sort the results if specified
	
			if(isset($select['sort']) && $select['sort'] && count($select['sort'])) {
				$sort = array();
				foreach($select['sort'] as $key => $value) {
					$sort[$key] = (int) $value;
				}
				$cursor->sort($sort);
			}
	
			// set a limit
	
			if(isset($select['limit']) && $select['limit']) {
				if(MONGO_LIST_MAX_PAGE_SIZE && $select['limit'] > MONGO_LIST_MAX_PAGE_SIZE) {
					$limit = MONGO_LIST_MAX_PAGE_SIZE;
				} else {
					$limit = $select['limit'];
				}
			} else {
				$limit = MONGO_LIST_DEFAULT_PAGE_SIZE;
			}
	
			if($limit) {
				$cursor->limit($limit);
			}
	
			// choose a page if specified
	
			if(isset($select['page']) && $select['page']) {
				$skip = (int)($limit * ($select['page'] - 1));
				$cursor->skip($skip);
			}
	
			// prepare results to be returned
	
			$output = array(
					'total' => $cursor->count(),
					'pages' => ceil($cursor->count() / $limit),
					'results' => array(),
			);
	
			foreach ($cursor as $result) {
				
				if ($flag) {
					$result = $this->getRefDouble($result);
				}
				

				// 'flattening' _id object in line with CRUD functions
				$result['_id'] = $result['_id']->{'$id'};
				$output['results'][] = $result;
			}
	
			$this->_conn->close();
	
			return $output;
	
		} catch (\MongoException $e) {
			$resultback = array('error' => $e->getMessage());
            $resultback = json_encode($resultback);
			die($resultback);
		}
	
	}
}