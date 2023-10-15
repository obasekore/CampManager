<?php

class ImageUploader
{
	var $min_width = NULL;
	var $min_height = NULL;
	var $byte_size = NULL;
	var $acceptable_mime = NULL;
	var $max_height = NULL;
	var $max_width = NULL;
	var $error = NULL;
	var $last_filename = NULL;
	
	function __construct()
	{
	}
	
	function restrict($mime, $max_byte_size, $max_width, $max_height, $min_width, $min_height)
	{
		$this->byte_size = $max_byte_size;
		
		$this->max_height = $max_height;
		$this->max_width = $max_width;
		
		$this->acceptable_mime = $mime;
		
		$this->min_height = $min_height;
		$this->min_width = $min_width;
	}
	
	function upload($tmp, $folder_storage, $new_filename, $allow_overwrite)
	{
		$bool = false;
		
		if(file_exists($tmp) and is_file($tmp))
		{
			if(is_uploaded_file($tmp))
			{
				if(getimagesize($tmp))
				{
					$gis = getimagesize($tmp);
					
					if(!is_null($this->min_height) and ($gis[1] < $this->min_height))
					{
						$this->error = "ERR_MIN_HEIGHT";
						return false;
					}
					
					if(!is_null($this->min_width) and ($gis[0] < $this->min_width))
					{
						$this->error = "ERR_MIN_WIDTH";
						return false;
					}
					
					if(!is_null($this->max_height) and ($gis[1] > $this->max_height))
					{
						$this->error = "ERR_MAX_HEIGHT";
						return false;
					}
					
					if(!is_null($this->max_width) and ($gis[0] > $this->max_width))
					{
						$this->error = "ERR_MAX_WIDTH";
						return false;
					}
					
					if(!is_null($this->byte_size) and (filesize($tmp) > $this->byte_size))
					{
						$this->error = "ERR_BYTE_SIZE";
						return false;
					}
					
					$mime = image_type_to_mime_type($gis[2]);
										
					if((is_array($this->acceptable_mime) and in_array($mime, $this->acceptable_mime)) or ($mime == $this->acceptable_mime))
					{
						$extension = image_type_to_extension($gis[2], true);
						
						$new_file = $folder_storage.$new_filename.$extension;
						
						if(file_exists($new_file) and !$allow_overwrite)
						{
							$i=1;
							
							do
							{
								$new_file = $folder_storage.$new_filename."_".$i++.$extension;
							}
							while(file_exists($new_file));
						}
						$this->last_filename = $new_file;
						
						$move = move_uploaded_file($tmp,$new_file);
						
						if($move)
						{
							$this->error = "ERR_OK";
							return true;
						}
						else
						{
							$this->error = "ERR_NOT_MOVE";
							return false;
						}
					}
					else
					{
						$this->error = "ERR_UNACCEPTED_MIME";
						return false;
					}
					
				}
				else
				{
					$this->error = "ERR_NOT_IMAGE";
					return false;
				}
			}
			else
			{
				$this->error = "ERR_FILE_NOT_UPLOADED";
				return false;
			}
		}
		else
		{
			$this->error = "ERR_FILE_NOT_EXIST";
			return false;
		}
	}
	
	function getLastUploadedFile()
	{
		if(!is_null($this->last_filename))
		{
			return $this->last_filename;
		}
		else
		{
			return false;
		}
	}
	
	function getLastErrorMessage()
	{
		$errmsg = NULL;
		switch($this->error)
		{
			case "ERR_FILE_NOT_EXIST":
			{
				$errmsg = "TMP File does not exist";
				break;
			}
			
			case "ERR_FILE_NOT_UPLOADED":
			{
				$errmsg = "File not uploaded";
				break;
			}
			
			case "ERR_NOT_IMAGE":
			{
				$errmsg = "Uploaded file is not an image";
				break;
			}
			
			case "ERR_UNACCEPTED_MIME":
			{
				$errmsg = "Unacceptable File (MIME) type";
				break;
			}
			
			case "ERR_NOT_MOVE":
			{
				$errmsg = "File could not be moved to storage location";
				break;
			}
			
			case "ERR_MIN_HEIGHT":
			{
				$errmsg = "Image height is below minimum";
				break;
			}
			
			case "ERR_MIN_WIDTH":
			{
				$errmsg = "Image width is below minimum";
				break;
			}
			
			case "ERR_MAX_HEIGHT":
			{
				$errmsg = "Image height is above maximum";
				break;
			}
			
			case "ERR_MAX_WIDTH":
			{
				$errmsg = "Image width is above maximum";
				break;
			}
			
			case "ERR_BYTE_SIZE":
			{
				$errmsg = "File size is above maximum";
				break;
			}
		}
		return $errmsg;
	}
	
	function getLastErrorCode()
	{
		return $this->error;
	}

	function getErrorMessageByCode($errorCode) {
		$tmpCode = $this->error;
		$this->error = $errorCode;
		$message = $this->getLastErrorMessage();
		$this->error = $tmpCode;

		return $message;
	}
}

?>