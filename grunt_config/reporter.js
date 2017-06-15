'use strict';

module.exports = {
    reporter: function (res) {

        var json = [];
        var error = 0;
        var currentFile = null;
        var messages = [];
        var i = 0;
        var j = 0;

        res.forEach(function (r) {
            if (r.file === currentFile){
                error ++;
            }
            else {
                if (currentFile) {
                    json[i] = {
                        'filePath': currentFile,
                        'errorCount': error,
                        'message' : messages
                    };
                    i++;
                }

                currentFile = r.file;
                error = 1;
                messages = [];
                j = 0;
            }

            messages[j] = {
                'ruleId': r.error.code,
                'severity': r.error.id,
                'line': r.error.line,
                'column': r.error.col,
                'character': r.error.evidence,
                'message': r.error.reason
            };

            j++;

        });

        json[i] = {
            'filePath': currentFile,
            'errorCount': error,
            'message' : messages
        };

        if(currentFile) {
            json = JSON.stringify(json);
            process.stdout.write( json);
        }
    }
};
