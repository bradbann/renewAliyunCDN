<?php
/**
 * TOP API: rds.aliyuncs.com.DescribeRealtimeDiagnoses.2014-08-15 request
 * 
 * @author auto create
 * @since 1.0, 2015.07.13
 */
class Rds20140815DescribeRealtimeDiagnosesRequest
{
	/** 
	 * 实例名称
	 **/
	private $dBInstanceId;
	
	/** 
	 * 查询结束时间，格式：2011-06-11T16:00Z，且大于查询开始时间
	 **/
	private $endTime;
	
	/** 
	 * 页码，大于0，且不超过Integer的最大值
	 **/
	private $page;
	
	/** 
	 * 每页记录数，取值：30|50|100
	 **/
	private $pageSize;
	
	/** 
	 * 查询开始时间，格式：yyyy-MM-dd’T’HH:mm:ssZ
	 **/
	private $startTime;
	
	/** 
	 * ownerId
	 **/
	private $ownerId;
	
	/** 
	 * resourceOwnerAccount
	 **/
	private $resourceOwnerAccount;
	
	/** 
	 * resourceOwnerId
	 **/
	private $resourceOwnerId;
	
	/**
	 * 仅用于渠道商发起API调用时，指定访问的资源拥有者的ID
	 **/
	private $ownerId;
	
	/**
	 *仅用于渠道商发起API调用时，指定访问的资源拥有者的账号
	 **/
    private  $ownerAccount;
    
    /**
     *API调用者试图通过API调用来访问别人拥有但已经授权给他的资源时，
     *通过使用该参数来声明此次操作涉及到的资源是谁名下的,该参数仅官网用户可用
     **/
    private $resourceOwnerAccount;
    
	private $apiParas = array();
	
	public function setdBInstanceId($dBInstanceId)
	{
		$this->dBInstanceId = $dBInstanceId;
		$this->apiParas["DBInstanceId"] = $dBInstanceId;
	}

	public function getdBInstanceId()
	{
		return $this->dBInstanceId;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
		$this->apiParas["EndTime"] = $endTime;
	}

	public function getEndTime()
	{
		return $this->endTime;
	}

	public function setPage($page)
	{
		$this->page = $page;
		$this->apiParas["Page"] = $page;
	}

	public function getPage()
	{
		return $this->page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
		$this->apiParas["PageSize"] = $pageSize;
	}

	public function getPageSize()
	{
		return $this->pageSize;
	}

	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
		$this->apiParas["StartTime"] = $startTime;
	}

	public function getStartTime()
	{
		return $this->startTime;
	}

	public function setOwnerId($ownerId)
	{
		$this->ownerId = $ownerId;
		$this->apiParas["ownerId"] = $ownerId;
	}

	public function getOwnerId()
	{
		return $this->ownerId;
	}

	public function setResourceOwnerAccount($resourceOwnerAccount)
	{
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->apiParas["resourceOwnerAccount"] = $resourceOwnerAccount;
	}

	public function getResourceOwnerAccount()
	{
		return $this->resourceOwnerAccount;
	}

	public function setResourceOwnerId($resourceOwnerId)
	{
		$this->resourceOwnerId = $resourceOwnerId;
		$this->apiParas["resourceOwnerId"] = $resourceOwnerId;
	}

	public function getResourceOwnerId()
	{
		return $this->resourceOwnerId;
	}

	
	public function setOwnerId($ownerId)
	{
		$this->ownerId = $ownerId;
		$this->apiParas["OwnerId"] = $ownerId;
	}
	
	public function getOwnerId()
	{
		return $this->ownerId;
	}
	
	public function setOwnerAccount($ownerAccount)
	{
		$this->ownerAccount = $ownerAccount;
		$this->apiParas["OwnerAccount"] = $ownerAccount;
	}
	
	public function getOwnerAccount()
	{
		return $this->ownerAccount;
	}
	
	public function setResourceOwnerAccount($resourceOwnerAccount)
	{
		$this->resourceOwnerAccount = $resourceOwnerAccount;
		$this->apiParas["ResourceOwnerAccount"] = $resourceOwnerAccount;
	}
	
	public function getResourceOwnerAccount()
	{
		return $this->resourceOwnerAccount;
	}

	public function getApiMethodName()
	{
		return "rds.aliyuncs.com.DescribeRealtimeDiagnoses.2014-08-15";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->dBInstanceId,"dBInstanceId");
		RequestCheckUtil::checkNotNull($this->endTime,"endTime");
		RequestCheckUtil::checkNotNull($this->startTime,"startTime");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}