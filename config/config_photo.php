<?php
  $inputerror = "";
  $notice = "";
  $fileuploadsizelimit = 2097152;//1048576;
  $fileuploaddir_orig = "photoupload_orig/";
  $fileuploaddir_normal = "photoupload_normal/";
  $fileuploaddir_thumb = "photoupload_thumb/";
  $allowed_photo_types = ["image/jpeg", "image/png", "image/gif", "image/jpg"];
  $filename = "";
  $filenameprefix = "vp_";
  $photomaxw = 600;
  $photomaxh = 400;
  $thumbsize = 100;
  $privacy = 1;
  $alttext = null;
  $watermark = "img/vp_logo_small.png";