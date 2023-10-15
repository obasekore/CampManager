<?php

class MaximPaginator
{
	
	private	$currentPage = 1;
	private	$maxPage = 1;
	private $recordPerpage = 1;
	private $urlcontent;
	private $query;
	private $vars;
	private $nextLink = "Next";
	private $previousLink = "Previous", $lastLink = "Last", $firstlink = "First";
	private $server_username;
	private $server_password;
	private $database_name;
	private $hostname;
	private $error = NULL;
	
	function Connect()
	{
		$conn = mysql_connect($this->hostname, $this->server_username, $this->server_password);
		if($conn)
		{
			$db = mysql_select_db($this->database_name);
			if(!$db)
			{
				$this->error = "Could not select database";
			}
		}
		else
		{
			$this->error = "Could not connect to server";
		}
	}
	
	function MaximPaginator($hostname, $server_username, $server_password, $database_name, $recordPerPage, $query)
	{
		$this->recordPerpage = intval($recordPerPage);
		$this->query = $query;
		$this->database_name = $database_name;
		$this->server_password = $server_password;
		$this->server_username = $server_username;
		$this->hostname = $hostname;
	}
	
	function setDefinedVars($definedVars)
	{
		$this->vars = $definedVars;
	}
	
	function getCurrentPage()
	{
		return $this->currentPage;
	}
	
	function getRecordPerPage()
	{
		return $this->recordPerpage;
	}
	
	function customiseNavigationLink($nextLink, $previousLink, $firstLink, $lastLink)
	{
		$this->nextLink = $nextLink;
		$this->previousLink = $previousLink;
		$this->firstlink = $firstLink;
		$this->lastLink = $lastLink;
	}
	
	private function retreiveGETs()
	{
		$urlcontent = "";
		$urlVars = $this->vars["_GET"];
		if(is_array($urlVars))
		{
			foreach($urlVars as $key => $value)
			{
				if($key != "page")
				{
					$urlcontent .= "&".$key."=".$value;
				}
			}
		}
		
		$this->urlcontent = $urlcontent;
		return true;
	}
	
	private function getLimits()
	{
		/**
		*	@param	string	$table	Name of SQL Table where record is to be retrieved
		*	@param	int	$recordPerPage	Number of Records to be displayed on the page
		*	@param	boolean	$config	Database Connection Configuration
		*	
		*	@return	array	$limits	Array of Lower Limit and Upper Limit which will be used in the SQL Query
		*
		*/
		
		if(isset($_REQUEST['page']) and is_numeric($_REQUEST['page']) and ($_REQUEST['page'] != 0))
		{
			$this->currentPage = intval($_REQUEST['page']);
		}
		else
		{
			$this->currentPage = 1;
		}
			$Query = mysql_query($this->query) or die("e: ".mysql_error());
			
			$recordNum = mysql_num_rows($Query);
			
			if($recordNum >0)
			{
				$this->maxPage = ceil($recordNum/($this->recordPerpage));
				
				if($this->currentPage > $this->maxPage)
				{
					$this->currentPage = $this->maxPage;
				}
				
				$lowerLimit = ($this->recordPerpage * ($this->currentPage -1));
				$upperLimit = ($this->currentPage * $this->recordPerpage);
				
				$limits = array();
				$limits[] = $lowerLimit;
				$limits[] = $upperLimit;
	
			}
			else
			{
				$limits = false;
			}
			
		return $limits;
	}
	
	function displayNavigator()
	{
		$this->retreiveGETs();
		
		$nav = "<table width=\"90\" border=\"0\" align=\"right\" cellpadding=\"1\" cellspacing=\"1\"><tr><td align=\"center\" width=\"25%\">";
	
		if($this->currentPage > 1)
		{
			$nav .= "<a href=\"".$_SERVER['PHP_SELF']."?page=1".$this->urlcontent."\">".$this->firstlink."</a>";
		}
		
		$nav .= "</td><td align=\"center\" width=\"25%\">";
		
		if(($this->currentPage > 1) and ($this->maxPage >1))
		{
			$nav .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($this->currentPage -1).$this->urlcontent."\" class='pager'>".$this->previousLink."</a>";
		}
		
		$nav .= "</td><td align=\"center\" width=\"25%\">";
		if(($this->currentPage < $this->maxPage) and ($this->maxPage >1))
		{
			$nav .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".($this->currentPage +1).$this->urlcontent."\">".$this->nextLink."</a>";
		}
		
		$nav .= "</td><td align=\"center\">";
		if(($this->currentPage < $this->maxPage) and ($this->maxPage >1))
		{
			$nav .= "<a href=\"".$_SERVER['PHP_SELF']."?page=".$this->maxPage.$this->urlcontent."\">".$this->lastLink."</a>";
		}
		
		$nav .= "</td></tr></table>";
		if(is_null($this->error))
		{
			echo $nav;
		}
		else
		{
			echo "";
		}
	}
	
	function getQueryResource()
	{
		$this->Connect();
		if(is_null($this->error))
		{
			$limits = $this->getLimits();
			$sql = $this->query." LIMIT $limits[0], $limits[1]";
			$query = mysql_query("$sql");
		}
		else
		{
			$query = NULL;
		}
		
		return $query;
	}
	
	function getTotalRecords()
	{
		return mysql_num_rows(mysql_query($this->query));
	}
}
?>
