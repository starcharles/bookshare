
/*
 |--------------------------------------------------------------------------
 | Browser-sync config file
 |--------------------------------------------------------------------------
 |
 | For up-to-date information about the options:
 |   http://www.browsersync.io/docs/options/
 |
 | There are more options than you see here, these are just the ones that are
 | set internally. See the website for more info.
 |
 |
 */
module.exports = {
    "files": ["./*.php","./*.css"],
    "server": false,
    "proxy": "localhost:8080",
    "port": 3000,
    "ghostMode": {
        "clicks": true,
        "scroll": true,
        "forms": {
            "submit": true,
            "inputs": true,
            "toggles": true
        }
    },
    "logLevel": "info",
    "logPrefix": "BS",
    "logConnections": false,
    "logFileChanges": true,
    "logSnippet": true,
    "snippetOptions": {
        "rule": {
            "match": {}
        }
    },
    "open": "external",
    "browser": "default",
    "xip": false,
    "hostnameSuffix": false,
    "reloadOnRestart": true,
    "notify": true,
    "scrollProportionally": true,
    "scrollThrottle": 0,
    "reloadDelay": 0,
    "injectChanges": true,
    "startPath": "/local.book_share",
    "minify": true,
    "host": null,
    "codeSync": true,
    "timestamps": true,
    "socket": {
        "path": "/browser-sync/socket.io",
        "clientPath": "/browser-sync",
        "namespace": "/browser-sync"
    },
    "debugInfo": true
};