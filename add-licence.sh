for find 
for i in *.js
do
  if ! grep -q Licence-Terms $i
  then
    cat ~/www/csbees/licence.txt $i > $i.new && mv $i.new $i
  fi
done
