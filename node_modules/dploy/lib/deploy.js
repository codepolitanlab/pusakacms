(function() {
  var Deploy, Signal, YAML, colors, exec, expand, fs, minimatch, path, prompt,
    __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; };

  colors = require("colors");

  path = require("path");

  fs = require("fs");

  YAML = require("yamljs");

  Signal = require("signals");

  expand = require("glob-expand");

  minimatch = require("minimatch");

  prompt = require("prompt");

  exec = require("child_process").exec;

  module.exports = Deploy = (function() {
    Deploy.prototype.server = null;

    Deploy.prototype.ignoreInclude = null;

    Deploy.prototype.local_hash = null;

    Deploy.prototype.remote_hash = null;

    Deploy.prototype.connection = null;

    Deploy.prototype.revisionPath = null;

    Deploy.prototype.connections = null;

    Deploy.prototype.numConnections = null;

    Deploy.prototype.toUpload = null;

    Deploy.prototype.toDelete = null;

    Deploy.prototype.dirCreated = null;

    Deploy.prototype.isConnected = null;

    Deploy.prototype.completed = null;

    /*
    	@constructor
    
    	@param	config (optional)		Default configuration for this server
    	@param	server (optional)		Set the server to load from the YAML file
    	@param	ignoreInclude (false)	Ignore the 'include' tag
    	@param	catchup (false)			Catchup with the server and only uploads the revision file
    */


    function Deploy(config, server, ignoreInclude, catchup) {
      this.config = config;
      this.server = server;
      this.ignoreInclude = ignoreInclude != null ? ignoreInclude : false;
      this.catchup = catchup != null ? catchup : false;
      this.complete = __bind(this.complete, this);
      this.dispose = __bind(this.dispose, this);
      this.removeConnections = __bind(this.removeConnections, this);
      this.setFolderAsCreated = __bind(this.setFolderAsCreated, this);
      this.deleteItem = __bind(this.deleteItem, this);
      this.uploadItem = __bind(this.uploadItem, this);
      this.checkBeforeUpload = __bind(this.checkBeforeUpload, this);
      this.canDelete = __bind(this.canDelete, this);
      this.canUpload = __bind(this.canUpload, this);
      this.completed = new Signal();
      this.connections = [];
      this.numConnections = 0;
      this.toUpload = [];
      this.toDelete = [];
      this.dirCreated = {};
      this.isConnected = false;
      prompt.message = "– ".red;
      prompt.delimiter = "";
      if (this.config != null) {
        this.configLoaded();
      } else {
        this.loadYAML();
      }
    }

    /*
    	Load the dploy.yaml, parse and find the current server
    */


    Deploy.prototype.loadYAML = function() {
      var _this = this;
      return fs.readFile("dploy.yaml", function(error, data) {
        var code, key, yaml;
        if (error) {
          return console.log("Error:".bold.red, "The file \"dploy.yaml\" could not be found.");
          process.exit(code = 0);
        }
        yaml = YAML.parse(data.toString());
        if (!_this.server) {
          for (key in yaml) {
            _this.server = key;
            break;
          }
        }
        _this.config = yaml[_this.server];
        if (!_this.config) {
          return console.log("Error:".bold.red, "We couldn't find the settings for " + ("" + _this.server).bold.red);
          process.exit(code = 0);
        }
        return _this.configLoaded();
      });
    };

    /*
    	Method for when the config file is loaded
    */


    Deploy.prototype.configLoaded = function() {
      this.setupFallbackConfig();
      return this.checkPassword(this.checkBranch);
    };

    /*
    	Set the fallback configuration
    */


    Deploy.prototype.setupFallbackConfig = function() {
      var regExpPath, _base, _base1, _base10, _base2, _base3, _base4, _base5, _base6, _base7, _base8, _base9;
      if (this.server == null) {
        this.server = this.config.host;
      }
      if ((_base = this.config).scheme == null) {
        _base.scheme = "ftp";
      }
      if ((_base1 = this.config).port == null) {
        _base1.port = (this.config.scheme === "ftp" ? 21 : 22);
      }
      if ((_base2 = this.config).secure == null) {
        _base2.secure = false;
      }
      if ((_base3 = this.config).secureOptions == null) {
        _base3.secureOptions = {};
      }
      if ((_base4 = this.config).slots == null) {
        _base4.slots = 1;
      }
      if ((_base5 = this.config).revision == null) {
        _base5.revision = ".rev";
      }
      if ((_base6 = this.config).path == null) {
        _base6.path = {};
      }
      if ((_base7 = this.config.path).local == null) {
        _base7.local = "";
      }
      if ((_base8 = this.config.path).remote == null) {
        _base8.remote = "";
      }
      if ((_base9 = this.config).exclude == null) {
        _base9.exclude = [];
      }
      if ((_base10 = this.config).include == null) {
        _base10.include = {};
      }
      regExpPath = new RegExp("(.*[^/]$)");
      if (this.config.path.local === "/") {
        this.config.path.local = "";
      }
      if (this.config.path.local !== "") {
        this.config.path.local = this.config.path.local.replace(regExpPath, "$1/");
      }
      if (this.config.path.remote !== "") {
        this.config.path.remote = this.config.path.remote.replace(regExpPath, "$1/");
      }
      this.revisionPath = this.config.path.local ? this.config.path.local + this.config.revision : this.config.revision;
      return this;
    };

    /*
    	This method will double check for the password, publicKey and privateKey
    	If none of those are found, DPLOY will prompt you to type it
    
    	@param	callback 				The callback for when the password is found
    */


    Deploy.prototype.checkPassword = function(callback) {
      var _this = this;
      if (this.config.pass) {
        return callback.call(this);
      }
      if (this.config.privateKey || this.config.publicKey && this.config.scheme === "sftp") {
        if (this.config.privateKey) {
          this.config.privateKey = fs.readFileSync(this._resolveHomeFolder(this.config.privateKey));
        }
        if (this.config.publicKey) {
          this.config.publicKey = fs.readFileSync(this._resolveHomeFolder(this.config.publicKey));
        }
        return callback.call(this);
      }
      prompt.get([
        {
          name: "password",
          description: "Enter the password for ".red + ("" + this.config.host + ":").underline.bold.red,
          required: true,
          hidden: true
        }
      ], function(error, result) {
        _this.config.pass = result.password;
        return callback.call(_this);
      });
    };

    /*
    	Check if the branch you are working on can be deployed to that server
    */


    Deploy.prototype.checkBranch = function() {
      var _this = this;
      if (!this.config.branch) {
        return this.setupGit();
      }
      if (typeof this.config.branch === "string") {
        this.config.branch = [this.config.branch];
      }
      return exec("git rev-parse --abbrev-ref HEAD", function(error, stdout, stderr) {
        var branch, currentBranch, _i, _len, _ref;
        if (error) {
          return console.log("An error occurred when retrieving the current branch.".bold.red, error);
        }
        currentBranch = stdout.replace(/\s/g, "");
        _ref = _this.config.branch;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          branch = _ref[_i];
          if (currentBranch === branch) {
            return _this.setupGit();
          }
        }
        console.log("Error: ".red.bold + "You are not allowed to deploy from ".red + ("" + currentBranch).bold.underline.red + " to ".red + ("" + _this.server).bold.underline.red);
        return _this.removeConnections(false);
      });
    };

    /*
    	Get the HEAD hash id so we can compare to the hash on the server
    */


    Deploy.prototype.setupGit = function() {
      var _this = this;
      console.log("Connecting to ".bold.yellow + ("" + this.server).bold.underline.yellow + "...".bold.yellow);
      return exec("git log --pretty=format:%H -n 1", function(error, stdout, stderr) {
        if (error) {
          return console.log("An error occurred when retrieving the local hash.".bold.red, error);
        }
        _this.local_hash = stdout;
        return _this.setupServer();
      });
    };

    /*
    	Connect to the server and once it's done, check for the remote revision file
    */


    Deploy.prototype.setupServer = function() {
      var scheme,
        _this = this;
      scheme = require("./scheme/" + this.config.scheme);
      this.connection = new scheme();
      this.connection.failed.add(function() {
        if (!_this.isConnected) {
          return console.log("Connection failed.".bold.red);
        }
      });
      this.connection.connected.add(function() {
        _this.isConnected = true;
        _this.numConnections++;
        _this.connections.push(_this.connection);
        return _this.checkRevision();
      });
      return this.connection.connect(this.config);
    };

    /*
    	Create more connections of your server for multiple uploads
    */


    Deploy.prototype.setupMultipleServers = function() {
      var con, scheme,
        _this = this;
      scheme = require("./scheme/" + this.config.scheme);
      con = new scheme();
      con.connected.add(function() {
        _this.connections.push(con);
        _this.numConnections++;
        return _this.nextOnQueue(con);
      });
      return con.connect(this.config);
    };

    /*
    	Check if the revision files exist, if not we will create one
    */


    Deploy.prototype.checkRevision = function() {
      var remotePath,
        _this = this;
      console.log("Checking revisions...".bold.yellow);
      remotePath = this._normalize(this.config.path.remote + this.config.revision);
      return this.connection.get(remotePath, function(error, data) {
        if (error) {
          fs.writeFile(_this.revisionPath, _this.local_hash, function(error) {
            if (error) {
              return console.log("Error creating revision file at:".red, ("" + _this.revisionPath).red.bold.underline, error);
            }
            return _this.addAll();
          });
          return;
        }
        fs.writeFileSync(_this.revisionPath, _this.local_hash);
        if (typeof data === "string") {
          _this.remote_hash = _this._removeSpecialChars(data);
          return _this.checkDiff(_this.remote_hash, _this.local_hash);
        } else {
          return data.on("data", function(e) {
            data.end();
            _this.remote_hash = _this._removeSpecialChars(e.toString());
            return _this.checkDiff(_this.remote_hash, _this.local_hash);
          });
        }
      });
    };

    /*
    	Get the diff tree between the local and remote revisions
    
    	@param	old_rev					The remote hash, usually it's the old version
    	@param	new_rev					The local hash, usually the latest one
    */


    Deploy.prototype.checkDiff = function(old_rev, new_rev) {
      var _this = this;
      if (!/([^\s])/.test(old_rev) || !/([^\s])/.test(new_rev)) {
        return this.addAll();
      }
      console.log("Checking diffs between".bold.yellow, ("[" + old_rev + "]").yellow, ">".yellow, ("[" + new_rev + "]").yellow);
      if (old_rev === new_rev) {
        if (this.config.include) {
          this.includeExtraFiles();
          if (this.config.check) {
            this.askBeforeUpload();
          } else {
            this.startUploads();
          }
          return;
        } else {
          console.log("No diffs between local and remote :)".blue);
          return this.removeConnections();
        }
      }
      return exec("git diff --name-status " + old_rev + " " + new_rev, {
        maxBuffer: 5000 * 1024
      }, function(error, stdout, stderr) {
        var data, detail, files, remoteName, _i, _len;
        if (error) {
          return console.log(("An error occurred when retrieving the 'git diff --name-status " + old_rev + " " + new_rev + "'").bold.red, error);
        }
        if (!_this.catchup) {
          files = stdout.split("\n");
          for (_i = 0, _len = files.length; _i < _len; _i++) {
            detail = files[_i];
            data = detail.split("\t");
            if (data.length > 1) {
              remoteName = _this.config.path.local ? data[1].split(_this.config.path.local).join("") : data[1];
              if (data[0] === "D") {
                if (_this.canDelete(data[1])) {
                  _this.toDelete.push({
                    name: data[1],
                    remote: remoteName
                  });
                }
              } else {
                if (_this.canUpload(data[1])) {
                  _this.toUpload.push({
                    name: data[1],
                    remote: remoteName
                  });
                }
              }
            }
          }
          _this.includeExtraFiles();
        }
        _this.toUpload.push({
          name: _this.revisionPath,
          remote: _this.config.revision
        });
        if (_this.config.check) {
          _this.askBeforeUpload();
        } else {
          _this.startUploads();
        }
      });
    };

    /*
    	Add the entire tree to our "toUpload" group
    */


    Deploy.prototype.addAll = function() {
      var _this = this;
      console.log("Uploading files...".bold.yellow);
      return exec("git ls-tree -r --name-only HEAD", {
        maxBuffer: 5000 * 1024
      }, function(error, stdout, stderr) {
        var detail, files, remoteName, _i, _len;
        if (error) {
          return console.log("An error occurred when retrieving 'git ls-tree -r --name-only HEAD'".bold.red, error);
        }
        if (!_this.catchup) {
          files = stdout.split("\n");
          for (_i = 0, _len = files.length; _i < _len; _i++) {
            detail = files[_i];
            remoteName = _this.config.path.local ? detail.split(_this.config.path.local).join("") : detail;
            if (_this.canUpload(detail)) {
              _this.toUpload.push({
                name: detail,
                remote: remoteName
              });
            }
          }
          _this.includeExtraFiles();
        }
        _this.toUpload.push({
          name: _this.revisionPath,
          remote: _this.config.revision
        });
        if (_this.config.check) {
          _this.askBeforeUpload();
        } else {
          _this.startUploads();
        }
      });
    };

    /*
    	Include extra files from the config file
    */


    Deploy.prototype.includeExtraFiles = function() {
      var file, files, key, match, remoteFile, _i, _len;
      if (this.ignoreInclude || this.catchup) {
        return false;
      }
      for (key in this.config.include) {
        files = expand({
          filter: "isFile",
          cwd: process.cwd()
        }, key);
        match = path.dirname(key).match(/^[0-9a-zA-Z_\-/\\]+/);
        for (_i = 0, _len = files.length; _i < _len; _i++) {
          file = files[_i];
          remoteFile = match && match.length ? file.substring(match[0].length) : file;
          remoteFile = this.config.include[key] + remoteFile;
          remoteFile = remoteFile.replace(/(\/\/)/g, "/");
          this.toUpload.push({
            name: file,
            remote: remoteFile
          });
        }
      }
      return true;
    };

    /*
    	Method to check if you can upload those files or not
    
    	@param	name (string)			The local file name
    	@return <boolean> if you can delete or not
    */


    Deploy.prototype.canUpload = function(name) {
      var exclude, _i, _len, _ref;
      if (name.length <= 0) {
        return false;
      }
      if (this.config.path.local) {
        if (name.indexOf(this.config.path.local) < 0) {
          return false;
        }
      }
      _ref = this.config.exclude;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        exclude = _ref[_i];
        if (minimatch(name, exclude, {
          dot: true
        })) {
          return false;
        }
      }
      return true;
    };

    /*
    	Method to check if you can delete those files or not
    
    	@param	name (string)			The local file name
    	@return <boolean> if you can delete or not
    */


    Deploy.prototype.canDelete = function(name) {
      if (name.length <= 0) {
        return false;
      }
      if (this.config.path.local) {
        if (name.indexOf(this.config.path.local) === 0) {
          return true;
        } else {
          return false;
        }
      }
      return true;
    };

    /*
    	Get the user's confirmation before uploading the file
    */


    Deploy.prototype.askBeforeUpload = function() {
      var file, remoteFile, _i, _j, _len, _len1, _ref, _ref1,
        _this = this;
      if (!this.hasFilesToUpload()) {
        return;
      }
      if (this.toDelete.length) {
        console.log("Files that will be deleted:".bold.red);
        _ref = this.toDelete;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          file = _ref[_i];
          console.log("[ ? ]".grey, ("" + file.remote).red);
        }
      }
      if (this.toUpload.length) {
        console.log("Files that will be uploaded:".bold.blue);
        _ref1 = this.toUpload;
        for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
          file = _ref1[_j];
          remoteFile = this._normalize(this.config.path.remote + file.remote);
          console.log("[ ? ]".blue, ("" + file.name).blue, ">".green, ("" + remoteFile).blue);
        }
      }
      prompt.start();
      return prompt.get([
        {
          name: "answer",
          pattern: /y|n|Y|N/,
          description: "Are you sure you want to upload those files?".bold.red + " (Y/n)",
          message: "The answer should be YES (y) or NO (n)."
        }
      ], function(error, result) {
        if (result.answer.toLowerCase() === "y" || result.answer.toLowerCase() === "") {
          return _this.startUploads();
        } else {
          console.log("Upload aborted by the user.".red);
          return _this.removeConnections(false);
        }
      });
    };

    /*
    	Start the upload and create the other connections if necessary
    */


    Deploy.prototype.startUploads = function() {
      var i;
      if (!this.hasFilesToUpload()) {
        return;
      }
      this.nextOnQueue(this.connection);
      i = this.config.slots - 1;
      while (i-- > 0) {
        this.setupMultipleServers();
      }
    };

    /*
    	Check if there's file to upload/delete
    
    	@return <boolean> if there's files or not
    */


    Deploy.prototype.hasFilesToUpload = function() {
      if (this.toUpload.length === 0 && this.toDelete.length === 0) {
        console.log("No files to upload".blue);
        this.removeConnections();
        return false;
      }
      return true;
    };

    /*
    	Upload or delete the next file in the queue
    	
    	@param	connection 				The FTP/SFTP connection to use
    */


    Deploy.prototype.nextOnQueue = function(connection) {
      var item, _i, _j, _k, _l, _len, _len1, _len2, _len3, _ref, _ref1, _ref2, _ref3;
      if (this.toDelete.length) {
        _ref = this.toDelete;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          item = _ref[_i];
          if (!item.started) {
            this.deleteItem(connection, item);
            return;
          }
        }
      }
      if (this.toUpload.length) {
        _ref1 = this.toUpload;
        for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
          item = _ref1[_j];
          if (!item.started) {
            this.checkBeforeUpload(connection, item);
            return;
          }
        }
      }
      _ref2 = this.toDelete;
      for (_k = 0, _len2 = _ref2.length; _k < _len2; _k++) {
        item = _ref2[_k];
        if (!item.completed) {
          return;
        }
      }
      _ref3 = this.toUpload;
      for (_l = 0, _len3 = _ref3.length; _l < _len3; _l++) {
        item = _ref3[_l];
        if (!item.completed) {
          return;
        }
      }
      return this.removeConnections();
    };

    /*
    	Check if the file is inside subfolders
    	If it's is, create the folders first and then upload the file.
    */


    Deploy.prototype.checkBeforeUpload = function(connection, item) {
      var folder, nameSplit,
        _this = this;
      item.started = true;
      nameSplit = item.remote.split("/");
      if (nameSplit.length > 1) {
        nameSplit.length = nameSplit.length - 1;
        folder = nameSplit.join("/");
        if (this.dirCreated[folder]) {
          this.uploadItem(connection, item);
          return;
        }
        return connection.mkdir(this._normalize(this.config.path.remote + folder), function(error) {
          if (!_this.dirCreated[folder]) {
            if (error) {

            } else {
              _this.setFolderAsCreated(folder);
            }
          }
          if (error) {
            item.started = false;
            return _this.nextOnQueue(connection);
          } else {
            return _this.uploadItem(connection, item);
          }
        });
      } else {
        return this.uploadItem(connection, item);
      }
    };

    /*
    	Upload the file to the remote directory
    	
    	@param	connection 				The FTP/SFTP connection to use
    	@param 	item 					The item to upload
    */


    Deploy.prototype.uploadItem = function(connection, item) {
      var remote_path,
        _this = this;
      remote_path = this._normalize(this.config.path.remote + item.remote);
      return connection.upload(item.name, remote_path, function(error) {
        if (error) {
          console.log("[ + ]".blue, ("Fail uploading file " + item.name + ":").red, error);
          item.started = false;
          item.completed = false;
        } else {
          console.log("[ + ]".blue + (" File uploaded: " + item.name + ":").blue);
          item.completed = true;
        }
        return _this.nextOnQueue(connection);
      });
    };

    /*
    	Delete an item from the remote server
    
    	@param	connection 				The FTP/SFTP connection to use
    	@param 	item 					The item to delete
    */


    Deploy.prototype.deleteItem = function(connection, item) {
      var remote_path,
        _this = this;
      item.started = true;
      remote_path = this._normalize(this.config.path.remote + item.remote);
      return connection["delete"](remote_path, function(error) {
        if (error) {
          console.log("[ × ]".grey, ("Fail deleting file " + remote_path + ":").red);
        } else {
          console.log("[ × ]".grey, ("File deleted: " + remote_path + ":").grey);
        }
        item.completed = true;
        return _this.nextOnQueue(connection);
      });
    };

    /*
    	When we are creating the folders in the remote server we got make sure
    	we don't try to rec-reate they, otherwise expect chaos
    */


    Deploy.prototype.setFolderAsCreated = function(folder) {
      var content, i;
      i = folder.lastIndexOf("/");
      if (this.dirCreated[folder]) {
        return;
      }
      while (i > 0) {
        content = folder.slice(0, i);
        this.dirCreated[content] = true;
        i = content.lastIndexOf("/");
      }
      return this.dirCreated[folder] = true;
    };

    /*
    	Remove/destroy all connections
    
    	@param displayMessage <true>	Set if you want to display a message for when the upload is completed
    */


    Deploy.prototype.removeConnections = function(displayMessage) {
      var con, _i, _len, _ref, _results,
        _this = this;
      if (displayMessage == null) {
        displayMessage = true;
      }
      if (this.numConnections > 0) {
        _ref = this.connections;
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          con = _ref[_i];
          con.closed.add(function() {
            _this.numConnections--;
            if (_this.numConnections === 0) {
              return _this.complete(displayMessage);
            }
          });
          _results.push(con.close());
        }
        return _results;
      } else {
        return this.complete(displayMessage);
      }
    };

    /*
    	Remove/destroy all connections
    */


    Deploy.prototype.dispose = function() {
      var con, _i, _len, _ref;
      if (this.completed) {
        _ref = this.connections;
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
          con = _ref[_i];
          con.dispose();
        }
        this.completed.dispose();
        return this.completed = null;
      }
    };

    /*
    	When everything is completed
    
    	@param displayMessage <true>	Set if you want to display a message for when the upload is completed
    */


    Deploy.prototype.complete = function(displayMessage) {
      var _this = this;
      return fs.unlink(this.revisionPath, function(err) {
        if (displayMessage) {
          console.log("Upload completed for ".green + ("" + _this.server).bold.underline.green);
        }
        return _this.completed.dispatch();
      });
    };

    Deploy.prototype._normalize = function(str) {
      return path.normalize(str).replace(/\\+/g, "/");
    };

    Deploy.prototype._removeSpecialChars = function(str) {
      return str.replace(/[\W]/g, "");
    };

    Deploy.prototype._resolveHomeFolder = function(str) {
      var homeFolder;
      homeFolder = process.env.HOME || process.env.HOMEPATH || process.env.USERPROFILE;
      if (str.substr(0, 1) === "~") {
        return path.resolve(path.join(homeFolder, str.substr(1)));
      }
      return str;
    };

    return Deploy;

  })();

}).call(this);
