# RKG Parsing Library
This library parses RKG files into an array.
**Credit http://github.com/jaames when used**  

## Usage
To load and parse from a file:
```php
// instanciate:
$rkg = new rkgParser();

// open a stream to parse:
$rkg->loadFromBuffer(fopen('file.rkg', 'r'));

// get metadata such as track ID, character ID, etc:
$metadata = $rkg->getMeta();

// get lap count and lap times:
$laps = $rkg->getLaps();

// get user data and location:
$userdata = $rkg->getUser();

// get raw Mii data:
$miidata = $rkg->getMiiData();
```

To load and parse from a HTTP stream (I.E. one from get_recent_rkg in class.ctgpLeaderboards.php):
```php
// instanciate:
$rkg = new rkgParser();

// open a stream to parse:
$rkg->loadFromString($string);

// get metadata such as track ID, character ID, etc:
$metadata = $rkg->getMeta();

// get lap count and lap times:
$laps = $rkg->getLaps();

// get user data and location:
$userdata = $rkg->getUser();

// get raw Mii data:
$miidata = $rkg->getMiiData();
```
All set variables are arrays.  

##Array Data

###`$userdata`:  
`countryid`: country ID (list at http://wiibrew.org/wiki/Country_Codes) in integer form  
`stateid`: unknown (probably location ID; i.e. in UK when one can pick Wales vs England), integer.  
`name`: String of Mii name (careful! this can have things like HTTP code in aswell as MKW-only characters)  

###`$metadata`:
`magic`: should always be 'RKGD'  
`time`: multi-dimensional array: `minutes`,`seconds`,`milliseconds` (integers)  
`trackID`: ID of track (0-31?)  
`vehicleID`: ID of vehicle  
`characterID`: ID of character  
`date`: multi-dimensional array: `year`, `month`, `day` (integers)  
`controllerID`: ID of controller  
`compressed`: if 1 then controller *data* is compressed.  
`ghostType`: type of ghost  
`automaticDrift`: Where they using automatic? 1 for yes, 0 for no.  
`inputDataLength`: (if you were using the input data) how long is it?  


###`$miidata`:
Your Mii file (no encoding or similar).  

###`$laps`:
`lapcount`: How many laps (1-5; any past 5 will not show because of MKW)  
`lapTimes`: multi-dimensional array, see below:  
`x`: Lap x (0-4):  
`minutes`: minutes (number)  
`seconds`: seconds (number)  
`milliseconds: milliseconds (number)  