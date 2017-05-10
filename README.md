# mkw-ghost-tools
![AGPL v3 Logo](http://pokeacer.xyz/images/AGPLv3.svg "This software is licensed under the AGPL v3 License.")

These are a set of PHP files that allow for playing about with various Mario Kart Wii online services, such as Top 10s (RACE), Competitions (also RACE), and ChadSoft's third-party Top10s.
Documentation is in the `docs` folder for each library.

## Usage
Copy the library folder to your app and include:
- `class.ctgpLeaderboardsIndex.php` for the most recent record data
- `class.rkgParser.php` for parsing an RKG file
- `class.wiimmfiLeaderboards.php` for Top10 downloading.
- `class.wiimmfiCompetitions.php` for Competition stuff.