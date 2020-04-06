c:\Portable\Git\usr\bin\find.exe ./tests/data -type f -name "example*.pdf" | xargs -n1 sh -c 'magick -density 300 "$0[0]" -background white -flatten "${0%.pdf}.png"'
