(function() {
  var Generator, Signal, fs;

  fs = require("fs");

  Signal = require("signals");

  module.exports = Generator = (function() {
    function Generator() {
      var code, packageConfig;
      packageConfig = require("../package.json");
      console.log("v" + packageConfig.version);
      process.exit(code = 0);
    }

    return Generator;

  })();

}).call(this);
