<?php

// ====== Mario Kart RKG (ghost trial data) Parser ======
//
// Based on the documentation found here:
// http://wiki.tockdom.com/wiki/RKG
//
// Written by James Daniel
// github.com/jaames | rakujira.jp

// ====== Usage ======
//
// instanciate:
// $rkg = new rkgParser();
//
// open a buffer to parse:
// $rkg->loadFromBuffer(fopen("./test.rkg", "r"));
//
// get metadata such as track ID, character ID, etc:
// $rkg->getMeta();
//
// get lap count and lap times:
// $rkg->getLaps());
//
// get user data and location:
// $rkg->getUser());
//
// get raw Mii data:
// $rkg->getMiiData();

class rkgParser {

  var $stream = null;

  // load a stream from an open buffer object
  function loadFromBuffer($buffer){
    $this->stream = $buffer;
  }
  // load a stream from a string
  function loadFromString($data){
    $this->stream = fopen("php://memory", "r+");
    fwrite($this->stream, $data);
  }
  // close the stream
  function close(){
    fclose($this->stream);
    $this->stream = null;
  }
  // should, hopefully, auto-close the stream when finished
  function __destruct() {
    if ($this->stream){
      $this->close();
    }
  }

  function _getFormatString($spec){
    $formatString = [];
    foreach ($spec as $var => $format) {
      array_push($formatString, $format . $var);
    }
    return join("/", $formatString);
  }

  function _parseTime($data) {
    // RKGs store track times in a 24-bit format
    // as PHP's unpack function doesn't support 24-bit ints, we have to use 32-bit ints instead
    //
    // so the $data passed into this function looks like this:
    // [7 bits - minutes][7 bits - seconds][10 bits - milliseconds][8 bits - some other data we dont want]
    // but we convert it to:
    // [8 bits - padding][7 bits - minutes][7 bits - seconds][10 bits - milliseconds]
    $data >>= 8;

    return [
      "minutes" => (($data >> 17) & 0x7F),
      "seconds" => (($data >> 10) & 0x7F),
      "milliseconds" => ($data & 0x3FF),
    ];

  }

  // get genarat
  function getMeta() {
    if (!$this->stream) {
      return null;
    }

    $spec = [
      "magic" => "a4",
      "flags1" => "N",
      "flags2" => "N",
      "flags3" => "n",
      "inputDataLength" => "n"
     ];

    // seek back to the beginning of the file
    fseek($this->stream, 0);

    $meta = unpack($this->_getFormatString($spec), fread($this->stream, 0x10));

    return [
      "magic" => $meta["magic"],
      // flags1 = [24 bits - time data (see parseTime function)][6 bits - track ID][2 bits - padding]
      "time" => $this->_parseTime($meta["flags1"]),
      "trackID" =>     (($meta["flags1"] >> 2 ) & 0x3F),
      // flags2 = [6 bits - vehicle ID][6 bits - character ID][7 bits - year(where 0 = the year 2000)][4 bits - month][5 bits - day][4 bits - controller type]
      "vehicleID" =>   (($meta["flags2"] >> 26) & 0x3F),
      "characterID" => (($meta["flags2"] >> 20) & 0x3F),
      "date" => [
        "year" =>  (($meta["flags2"] >> 13) & 0x7F) + 2000,
        "month" => (($meta["flags2"] >> 9 ) & 0xF),
        "day" =>   (($meta["flags2"] >> 4 ) & 0x1F)
      ],
      "controllerID" =>   ($meta["flags2"] & 0xF),
      // flags3 = [4 bits - padding][1 bit - compression flag][2 bits - padding][7 bits - ghost type][1 bit - drift type][1 bit - padding]
      "compressed" =>     (($meta["flags3"] >> 11) & 0x01),
      "ghostType" =>      (($meta["flags3"] >> 2 ) & 0x3F),
      "automaticDrift" => (($meta["flags3"] >> 1 ) & 0x1),
      "inputDataLength" => $meta["inputDataLength"]
    ];
  }

  // get the number of laps and the time for each lap
  function getLaps() {
    if (!$this->stream) {
      return null;
    }
    // seek to the start of the lap data
    fseek($this->stream, 0x10);

    // get the number of laps done
    $lapCount = unpack("C", fread($this->stream, 1))[1];

    $lapTimes = Array();

    // for each lap, extract the lap time
    for ($lapIndex = 0; $lapIndex < $lapCount; $lapIndex++) {
      // PHP's unpack doesn't work with 24-bit ints, so we have do a bit of work to seek to the right offset
      fseek($this->stream, 17 + ($lapIndex * 3));
      // unpack lap time as 32-bit ints
      $data = unpack("N", fread($this->stream, 4))[1];
      // parse the time data and push it to the lapTimes array, parseTime takes a 32-bit int but will discard the last 8 bits
      array_push($lapTimes, $this->_parseTime($data));
    }

    return [
      "lapCount" => $lapCount,
      "lapTimes" => $lapTimes
    ];

  }

  // get basic user information, such as country, state, and name
  function getUser(){
    if (!$this->stream) {
      return null;
    }
    $spec = [
      "countryID" => "C",
      "stateID" => "C",
      "locationSharing" => "n",
      "padding" => "x4",
      "miiHeader" => "x2",
      "miiName" => "a20"
    ];
    // seek to the start of the user data
    fseek($this->stream, 0x34);
    $meta = unpack($this->_getFormatString($spec), fread($this->stream, 0x48));
    return [
      "countryID" => $meta["countryID"],
      "stateID" => $meta["stateID"],
      "name" => trim(mb_convert_encoding($meta["miiName"], "UTF-8", "UTF-16BE"), "\0")
    ];
  }

  // get the raw Mii data if you so wished (:
  function getMiiData(){
    if (!$this->stream) {
      return null;
    }
    fseek($this->stream, 0x3C);
    return fread($this->stream, 0x4A);
  }
}
