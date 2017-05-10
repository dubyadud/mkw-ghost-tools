# Wiimmfi Leaderboard Library
This library allows you to get results for ghosts and top10s from Wiimmfi's Leaderboards.
**Credit PokeAcer when used**  

## Usage
To get the top10 (array) for a course:
`get_wiimmfi_top10(x)` where x = trackID  
`["numrecords"]` holds how many records there are (0-10) - This way you know how many ranking data requests to get.
`["data"]["RankingData"][$num]` where $num is 0-9 - This lets you see (add onto end of [$num]):
- `["userdata"]`: Mii data (in base64)
- `["ownerid"]`: PID of user
- `["rank"]`: To know what rank they are (1-10; records can be sent out of order so this is what is used to fix that)
- `["time"]`: This is a tricky one: If milliseconds are .0xx then the last two digits are milliseconds, else the last 3 are milliseconds (I do not know what .0 is) and the rest is seconds: Example, for 00:32.818 = 32818 yet 182587 = 03:02.587; check if there are 5 or 6 digits is what I'd say to do.
