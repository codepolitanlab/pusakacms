(function() {
  var FTP, Signal, ftp;

  ftp = require("ftp");

  Signal = require("signals");

  module.exports = FTP = (function() {
    FTP.prototype.connection = null;

    FTP.prototype.connected = null;

    FTP.prototype.failed = null;

    FTP.prototype.closed = null;

    function FTP() {
      var _this = this;
      this.connected = new Signal();
      this.failed = new Signal();
      this.closed = new Signal();
      this.connection = new ftp();
      this.connection.on("error", function() {
        return _this.failed.dispatch();
      });
      this.connection.on("ready", function() {
        return _this.connected.dispatch();
      });
    }

    /*
    	Connect to the FTP
    
    	@param config <object> Configuration file for your connection
    */


    FTP.prototype.connect = function(config) {
      return this.connection.connect({
        host: config.host,
        port: config.port,
        user: config.user,
        password: config.pass,
        secure: config.secure,
        secureOptions: config.secureOptions
      });
    };

    /*
    	Close the connection
    */


    FTP.prototype.close = function(callback) {
      var _this = this;
      this.connection.on("end", function() {
        return _this.closed.dispatch();
      });
      return this.connection.end();
    };

    /*
    	Dispose
    */


    FTP.prototype.dispose = function() {
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


    FTP.prototype.get = function(path, callback) {
      return this.connection.get(path, callback);
    };

    /*
    	Upload a file to the server
    
    	@param local_path: <string> The local path of your file
    	@param remote_path: <string> The remote path where you want your file to be uploaded at
    	@param callback: <function> Callback method
    */


    FTP.prototype.upload = function(local_path, remote_path, callback) {
      return this.connection.put(local_path, remote_path, callback);
    };

    /*
    	Delete a file from the server
    
    	@param remote_path: <string> The remote path you want to delete
    	@param callback: <function> Callback method
    */


    FTP.prototype["delete"] = function(remote_path, callback) {
      return this.connection["delete"](remote_path, callback);
    };

    /*
    	Create a directory
    
    	@param path: <string> The path of the directory you want to create
    	@param callback: <function> Callback method
    */


    FTP.prototype.mkdir = function(path, callback) {
      return this.connection.mkdir(path, true, callback);
    };

    return FTP;

  })();

}).call(this);
