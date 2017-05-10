# mkw-ghost-tools
![AGPL v3 Logo](https://www.gnu.org/graphics/agplv3-155x51.png "This software is licensed under the AGPL v3 License.")
These are a set of PHP tools that allow downloading of Top 10s and RKGs from Chadsoft, but only Top10s from Wiimmfi, aswell as parsing said data.
Documentation is in the `docs` folder for each library.

##Usage
Copy the library folder to your app and include:
- `class.ctgpLeaderboardsIndex.php` for the most recent record data
- `class.rkgParser.php` for parsing an RKG file
- `class.wiimmfiLeaderboards.php` for Top10 downloading.
- `class.wiimmfiCompetitions.php` for Competition stuff.