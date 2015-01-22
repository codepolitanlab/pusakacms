if (!RedactorPlugins) var RedactorPlugins = {};
 
RedactorPlugins.bufferbuttons = function()
{
    return {
        init: function()
        {
            var undo = this.button.addFirst('undo', 'Undo');
            var redo = this.button.addAfter('undo', 'redo', 'Redo');
 
            this.button.addCallback(undo, this.buffer.undo);
            this.button.addCallback(redo, this.buffer.redo);
        }
    };
};