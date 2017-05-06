
// require modules
var fs = require('fs');
var archiver = require('archiver');

// create a file to stream archive data to.
var output = fs.createWriteStream('calendar.zip');
var archive = archiver('zip', {
    zlib: { level: 9 } // Sets the compression level.
});

// listen for all archive data to be written
output.on('close', function() {
  console.log(archive.pointer() + ' total bytes');
  console.log('archiver has been finalized and the output file descriptor has closed.');
});

// good practice to catch this error explicitly
archive.on('error', function(err) {
  throw err;
});

// pipe archive data to the file
archive.pipe(output);

var directories = [ 
    'app/bundle/',
    'assets',
    'languages',
    'src',
    'views'
];

var files = [ 
    'composer.json',
    'index.php',
    'scripts.php'
]

for (var i = 0; i < directories.length; i++) {
    //archive.file(files[i], { name: files[i] });
    archive.directory(directories[i]);
}

for (var i = 0; i < files.length; i++) {
    archive.file(files[i], { name: files[i] });
}

// finalize the archive (ie we are done appending files but streams have to finish yet)
archive.finalize();