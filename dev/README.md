### Release 3.4.0

```shell
cd tests\data
git mv testTableModel1.png draw-table-model1.png
git mv testTableModel2.png draw-table-model2.png
git mv testTableModel3.png draw-table-model3.png
git mv testTableModel1.pdf draw-table-model1.pdf
git mv testTableModel2.pdf draw-table-model2.pdf
git mv testTableModel3.pdf draw-table-model3.pdf
```

## Development

```shell
bcompare ./tests/data/is ./tests/data/expected
```

Run a specific docker version to execute unit-tests

```shell
docker run -it --privileged -v D:\Projects\pdf-addons\fpdf-table:/srv -t php56 bash
docker run -it --privileged -v D:\Projects\pdf-addons\tcpdf-table:/srv -t php74 bash


docker run -it --privileged -t php73 php -v
```
