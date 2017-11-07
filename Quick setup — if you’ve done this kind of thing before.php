…or create a new repository on the command line

echo "# useful-files" >> README.md
git init
git add README.md
git commit -m "first commit"
git remote add origin https://github.com/haseri/useful-files.git
git push -u origin master