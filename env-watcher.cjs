const fs = require('fs');
const { exec } = require('child_process');
const path = require('path');

const envPath = path.join(__dirname, '.env');
let lastMtime = fs.statSync(envPath).mtimeMs;

console.log('[Env Watcher] Watching .env for changes...');

setInterval(() => {
    try {
        const stats = fs.statSync(envPath);
        if (stats.mtimeMs > lastMtime) {
            lastMtime = stats.mtimeMs;
            console.log('[Env Watcher] .env changed, restarting queue workers...');
            exec('php artisan queue:restart', { cwd: __dirname }, (err, stdout, stderr) => {
                if (err) {
                    console.error('[Env Watcher] Error:', stderr);
                } else {
                    console.log('[Env Watcher] Queue restart signal sent.');
                }
            });
        }
    } catch (e) {
        // .env might not exist temporarily
    }
}, 1000);
