curl -X DELETE \
  -H "Content-Type: application/json" \
  http://localhost:8080/api/utilisateur/1

curl -X POST \
  -H "Content-Type: application/json" \
  -d '{"nom":"Basket"}' \
  http://localhost:8080/api/discipline

curl -X PUT \
  -H "Content-Type: application/json" \
  -d '{"nom":"manoa","mdp":"manoa"}' \
  http://localhost:8080/api/utilisateur/3

curl -X GET \
  -H "Content-Type: application/json" \
  http://localhost:8080/api/utilisateur


curl -X GET \
  -H "Content-Type: application/json" \
  --ssh-key /home/johan/Documents/Prepas/Interprom-2024/Archive-cle/id_rsa\
  --key /home/johan/Documents/Prepas/Interprom-2024/Archive-cle/id_rsa.pub\
  --key-password \
  https://itusport.123mada.com
