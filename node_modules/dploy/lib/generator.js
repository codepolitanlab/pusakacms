(function() {
  var Generator, Signal, colors, fs, path,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  colors = require("colors");

  fs = require("fs");

  path = require("path");

  Signal = require("signals");

  module.exports = Generator = (function() {
    function Generator() {
      this._generatePostCommit = __bind(this._generatePostCommit, this);
      this._generateConfig = __bind(this._generateConfig, this);
      this._dployCompleted = new Signal();
      this._dployCompleted.add(this._generatePostCommit);
      this._postCommitCompleted = new Signal();
      this._postCommitCompleted.add(this._completed);
      console.log("Installing ".yellow + "DPLOY".bold.yellow + "...".yellow);
      this._generateConfig();
    }

    Generator.prototype._generateConfig = function() {
      var fileName;
      fileName = "dploy.yaml";
      if (!fs.existsSync(fileName)) {
        fs.createReadStream(path.resolve(__dirname, "../generator/dploy.yaml")).pipe(fs.createWriteStream(fileName));
      }
      return this._dployCompleted.dispatch();
    };

    Generator.prototype._generatePostCommit = function() {
      var content, fileData, fileName,
        _this = this;
      if (!fs.existsSync(".git")) {
        return this._postCommitCompleted.dispatch();
      }
      fileName = ".git/hooks/post-commit";
      content = fs.readFileSync(path.resolve(__dirname, "../generator/post-commit")).toString();
      if (fs.existsSync(fileName)) {
        fileData = fs.readFileSync(fileName).toString();
        if (fileData.toLowerCase().indexOf("dploy") >= 0) {
          return this._postCommitCompleted.dispatch();
        }
        if (fileData.indexOf("#!/bin/bash") >= 0) {
          content = content.replace(new RegExp("#!\/bin\/bash", "g"), "");
        }
      }
      return fs.appendFile(fileName, content, function(error) {
        if (error) {
          console.log("Error:".bold.red, "The post-commit file could not be created. Check the permissions of the folder.".red);
          console.log("\t " + error);
          return _this._postCommitCompleted.dispatch();
        }
        fs.chmodSync(fileName, "0755");
        return _this._postCommitCompleted.dispatch();
      });
    };

    Generator.prototype._completed = function() {
      var code;
      console.log("Done!".bold.green + " Your project is ready to ".green + "DEPLOY".green.bold + " :) ".green);
      return process.exit(code = 0);
    };

    return Generator;

  })();

}).call(this);
