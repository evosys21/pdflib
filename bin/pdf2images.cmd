find.exe ./tests/data -type f -name "*.pdf"   | xargs -n1 sh -c 'magick -verbose -density 300 "$0[0]" -background white -flatten "${0%%.pdf}.png"'
