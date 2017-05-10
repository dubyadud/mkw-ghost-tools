# CTGP Leaderboard Library
This library uses the CTGP-R Leaderboard from Chadsoft, via Chadderz's JSON interface.  
**Credit PokeAcer549 when used**  

##Usage
Use `class.ctgpLeaderboardsIndex.php` for any function labelled with [I].

## Functions

### [I]`get_recent_rkg`
This will return an RKG file for the recent record specified.
Usage: `get_recent_rkg(num)` where num is between 0-5.    

### [I]`get_recent_rkg_url`
This will return the URL for an RKG file for the recent record specified (which is what get_recent_rkg uses)
Usage: `get_recent_rkg_url(num)` where num is between 0-5.    

### [I]`get_recent_rkg_data`
This lets you ask for data from the below data list.
Usage: `get_recent_rkg_data(x, y)` where x is between 0-5 and y is one of the below given data types.


## Types of data for `get_recent_rkg_data`
- href: RKG relative URL
- finishTime: time (MM:SS.verylongamountofmicroseconds)
- finishTimeSimple: MM:SS.SSS
- bestSplit: best split
- bestSplitSimple: best split (time simplified)
- hash: SHA1 of file
- vehicleId: integer of vehicle ID
- driverId: integer of driver ID
- dateSet: Time when set (YYYY- MM- DD'T'HH:MM:SS'Z')