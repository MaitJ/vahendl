<?php
	class Photoupload{
		private $photoinput;
		private $imagetype;
		private $mytempimage;
		private $allowedImageTypes;
		private $fileUploadSizeLimit;
		private $mynewtempimage;
		private $fileName;
		
		function __construct($photoinput, $allowedImageTypes, $fileUploadSizeLimit){
			$this->photoinput = $photoinput;
			$this->allowedImageTypes = $allowedImageTypes;
			$this->fileUploadSizeLimit = $fileUploadSizeLimit;
			//var_dump($this->photoinput);
		}
		
		function __destruct(){
			imagedestroy($this->mytempimage);
		}

		public function setImageType() {
			$result = "";
			$fileInfo = getimagesize($this->photoinput["tmp_name"]);
			if (in_array($fileInfo["mime"], $this->allowedImageTypes)) {
				$splitType = explode("/", $fileInfo["mime"]);
				$this->imagetype = $splitType[1];
			}
			else {
				$result = "Tundmatu/mitte lubatud faili tyyp";
			}

			return $result;
		}

		public function checkSize() {
			$result = "";
			if($this->photoinput["size"] > $this->fileUploadSizeLimit){
				$result .= " Valitud fail on liiga suur!";
			}
			return $result;
		}

		public function generateFileName($filenameprefix) {
			$timestamp = microtime(1) * 10000;
			$this->fileName = $filenameprefix .$timestamp ."." .$this->imagetype;
		}
		
		public function createImageFromFile(){
			if($this->imagetype == "jpg" || $this->imagetype == "jpeg"){
				$this->mytempimage = imagecreatefromjpeg($this->photoinput["tmp_name"]);
			}
			if($this->imagetype == "png"){
				$this->mytempimage = imagecreatefrompng($this->photoinput["tmp_name"]);
			}
			if($this->imagetype == "gif"){
				$this->mytempimage = imagecreatefromgif($this->photoinput["tmp_name"]);
			}
		}

		public function exists($fileuploaddir_orig) {
			$result = "";
			if(file_exists($fileuploaddir_orig .$this->fileName)){
				$result .= " Sellise nimega fail on juba olemas!";
			}
			return $result;
		}
		
		public function resizePhoto($w, $h, $keeporigproportion = true){
			$imagew = imagesx($this->mytempimage);
			$imageh = imagesy($this->mytempimage);
			$neww = $w;
			$newh = $h;
			$cutx = 0;
			$cuty = 0;
			$cutsizew = $imagew;
			$cutsizeh = $imageh;
			
			if($w == $h){
				if($imagew > $imageh){
					$cutsizew = $imageh;
					$cutx = round(($imagew - $cutsizew) / 2);
				} else {
					$cutsizeh = $imagew;
					$cuty = round(($imageh - $cutsizeh) / 2);
				}	
			} elseif($keeporigproportion){//kui tuleb originaaproportsioone säilitada
				if($imagew / $w > $imageh / $h){
					$newh = round($imageh / ($imagew / $w));
				} else {
					$neww = round($imagew / ($imageh / $h));
				}
			} else { //kui on vaja kindlasti etteantud suurust, ehk pisut ka kärpida
				if($imagew / $w < $imageh / $h){
					$cutsizeh = round($imagew / $w * $h);
					$cuty = round(($imageh - $cutsizeh) / 2);
				} else {
					$cutsizew = round($imageh / $h * $w);
					$cutx = round(($imagew - $cutsizew) / 2);
				}
			}
			
			//loome uue ajutise pildiobjekti
			$this->mynewtempimage = imagecreatetruecolor($neww, $newh);
			//kui on läbipaistvusega png pildid, siis on vaja säilitada läbipaistvusega
			imagesavealpha($this->mynewtempimage, true);
			$transcolor = imagecolorallocatealpha($this->mynewtempimage, 0, 0, 0, 127);
			imagefill($this->mynewtempimage, 0, 0, $transcolor);
			imagecopyresampled($this->mynewtempimage, $this->mytempimage, 0, 0, $cutx, $cuty, $neww, $newh, $cutsizew, $cutsizeh);
		}
		
		public function addWatermark($wmf){
			if(isset($this->mynewtempimage)){
				$watermark = imagecreatefrompng($wmf);
				$wmw = imagesx($watermark);
				$wmh = imagesy($watermark);
				$wmx = imagesx($this->mynewtempimage) - $wmw - 10;
				$wmy = imagesy($this->mynewtempimage) - $wmh - 10;
				//kopeerin vesimärgi pildile
				imagecopy($this->mynewtempimage, $watermark, $wmx, $wmy, 0, 0, $wmw, $wmh);
				imagedestroy($watermark);
			}
		}
		
		public function savePhotoFile($target){
			$notice = null;
			if($this->imagetype == "jpg" || $this->imagetype == "jpeg"){
				if(imagejpeg($this->mynewtempimage, $target .$this->fileName, 90)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			if($this->imagetype == "png"){
				if(imagepng($this->mynewtempimage, $target .$this->fileName, 6)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			if($this->imagetype == "gif"){
				if(imagegif($this->mynewtempimage, $target .$this->fileName)){
					$notice = 1;
				} else {
					$notice = 0;
				}
			}
			imagedestroy($this->mynewtempimage);
			return $notice;
		}
		
		public function saveOriginalPhoto($target){
			$notice = null;
			if(move_uploaded_file($this->photoinput["tmp_name"], $target .$this->imagetype)){
				$notice = 1;
			} else {
				$notice = 0;
			}
			return $notice;
		}
        
        public function storePhotoData($alttext, $privacy){
            $notice = null;
            $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
            $stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
            echo $conn->error;
            $stmt->bind_param("issi", $_SESSION["userid"], $this->fileName, $alttext, $privacy);
            if($stmt->execute()){
                $notice = 1;
            } else {
                //echo $stmt->error;
                $notice = 0;
            }
            $stmt->close();
            $conn->close();
            return $notice;
        }

	}