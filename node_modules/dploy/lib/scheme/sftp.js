(function() {
  var SFTP, Signal, fs, ssh2;

  ssh2 = require("ssh2");

  Signal = require("signals");

  fs = require("fs");

  module.exports = SFTP = (function() {
    SFTP.prototype.sftp = null;

    SFTP.prototype.connection = null;

    SFTP.prototype.connected = null;

    SFTP.prototype.failed = null;

    SFTP.prototype.closed = null;

    SFTP.prototype.closing = null;

    function SFTP() {
      var _this = this;
      this.connected = new Signal();
      this.failed = new Signal();
      this.closed = new Signal();
      this.closing = false;
      this.sftp = new ssh2();
      this.sftp.on("error", function() {
        if (!_this.closing) {
          return _this.failed.dispatch();
        }
      });
      this.sftp.on("close", function(hadError) {
        if (_this.hadError) {
          if (!_this.closing) {
            return _this.failed.dispatch();
          }
        }
      });
      this.sftp.on("ready", function() {
        return _this.sftp.sftp(function(error, connection) {
          if (error) {
            return _this.failed.dispatch();
          }
          _this.connection = connection;
          return _this.connected.dispatch();
        });
      });
    }

    /*
    	Connect to the FTP
    	@param config <object> Configuration file for your connection
    */


    SFTP.prototype.connect = function(config) {
      return this.sftp.connect({
        host: config.host,
        port: config.port,
        username: config.user,
        password: config.pass,
        privateKey: config.privateKey,
        publicKey: config.publicKey,
        passphrase: config.passphrase
      });
    };

    /*
    	Close the connection
    */


    SFTP.prototype.close = function(callback) {
      var _this = this;
      if (this.closing) {
        return;
      }
      this.closing = true;
      this.sftp.on("end", function() {
        return _this.closed.dispatch();
      });
      return this.sftp.end();
    };

    /*
    	Dispose
    */


    SFTP.prototype.dispose = function() {
      if (this.connected) {
        this.connected.dispose();
        this.connected = null;
      }
      if (this.failed) {
        this.failed.dispose();
        this.failed = null;
      }
      if (this.closed) {
        this.closed.dispose();
        return this.closed = null;
      }
    };

    /*
    	Retrieve a file on the server
    
    	@param path: <string> The path of your file
    	@param callback: <function> Callback method
    */


    SFTP.prototype.get = function(path, callback) {
      return this.connection.readFile(path, "utf-8", callback);
    };

    /*
    	Upload a file to the server
    
    	@param local_path: <string> The local path of your file
    	@param remote_path: <string> The remote path where you want your file to be uploaded at
    	@param callback: <function> Callback method
    */


    SFTP.prototype.upload = function(local_path, remote_path, callback) {
      return this.connection.fastPut(local_path, remote_path, callback);
    };

    /*
    	Delete a file from the server
    
    	@param remote_path: <string> The remote path you want to delete
    	@param callback: <function> Callback method
    */


    SFTP.prototype["delete"] = function(remote_path, callback) {
      var content, i, paths,
        _this = this;
      i = remote_path.lastIndexOf("/");
      paths = [];
      while (i > 0) {
        content = remote_path.slice(0, i);
        paths.push(content);
        i = content.lastIndexOf("/");
      }
      return this.connection.unlink(remote_path, function(error) {
        if (error) {
          return callback.apply(_this, [error]);
        }
        return _this._rdelete(paths, callback);
      });
    };

    /*
    	@private
    	Delete directories recursively
    */


    SFTP.prototype._rdelete = function(paths, callback) {
      var path,
        _this = this;
      path = paths.shift();
      return this.connection.opendir(path, function(error, handle) {
        if (error) {
          return callback.apply(_this, [error]);
        }
        return _this.connection.readdir(handle, function(error, list) {
          if (error || paths.length === 0) {
            return callback.apply(_this, [error]);
          }
          if (list.length <= 2) {
            return _this.connection.rmdir(path, function(error) {
              if (error || paths.length === 0) {
                return callback.apply(_this, [error]);
              }
              return _this._rdelete(paths, callback);
            });
          } else {
            return callback.apply(_this, [error]);
          }
        });
      });
    };

    /*
    	Create a directory
    
    	@param path: <string> The path of the directory you want to create
    	@param callback: <function> Callback method
    */


    SFTP.prototype.mkdir = function(path, callback) {
      var content, i, paths;
      i = path.length;
      paths = [];
      while (i > 0) {
        content = path.slice(0, i);
        paths.push(content);
        i = content.lastIndexOf("/");
      }
      return this._rmkdir(paths, callback);
    };

    /*
    	@private
    	Create directories recursively
    */


    SFTP.prototype._rmkdir = function(paths, callback) {
      var path,
        _this = this;
      path = paths.pop();
      return this.connection.opendir(path, function(error, handle) {
        if (error) {
          return _this.connection.mkdir(path, function(error) {
            if (error || paths.length === 0) {
              return callback.apply(_this, [error]);
            }
            return _this._rmkdir(paths, callback);
          });
        } else {
          if (paths.length === 0) {
            return callback.apply(_this, [void 0]);
          }
          return _this._rmkdir(paths, callback);
        }
      });
    };

    return SFTP;

  })();

}).call(this);
