# Wiimmfi Competitions
This function library allows you to download and return competition text and data.
**Credit [PokeAcer(549)](http://github.com/PokeAcer549) when used**  

# Functions

## get_competition_text($region, $id)
This function will return the competition text, for the region (defaults to EU English if not specified), and uses the Wii ID specified (defaults to a random ID).

## get_competition_letter($region, $id)
This function does the same as get_competition_text however gives the fully formatted file, and trims nothing (it's in full announcement form).

## get_competition_bin($region, $id)
This will return the competition BIN file (distmap.bin) that the Wii downloads from Wiimmfi for competition data - this could be useful for archiving Wiimmfi competitions.

## save_competition_bin($region, $id)
This function does the same as get_competition_bin however it will save it to a random filename (it will return the filename - echo save_competition_bin($region, $id) will give you the filename.