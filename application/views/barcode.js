const JsBarcode = require('jsbarcode');

JsBarcode("#barcode", "Example1234", { format: "CODE128" });

JsBarcode("#barcode", "123456789012", {
    format: "CODE128",
    width: 3,
    height: 150,
    text: "Hi!",
    fontOptions: "bold italic",
    font: "fantasy",
    textMargin: 25,
});
