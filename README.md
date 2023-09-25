curl --location --request POST 'http://0.0.0.0:80/purchase' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJVc2VyIERldGFpbHMiLCJpc3MiOiJZT1VSIEFQUExJQ0FUSU9OL1BST0pFQ1QvQ09NUEFOWSBOQU1FIiwiaWF0IjoxNjg5NDU0OTM2LCJlbWFpbCI6ImNvbXBhbnlAYXBwbGUuY29tIn0.CPajhyM6E1VJttxRWCAH2rsC7uOep2hrKHEUYnmo1Vk' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
"product": 1,
"couponCode": "percent",
"taxNumber": "FR123456789",
"paymentProcessor": "stripe"
}'


curl --location --request POST 'http://0.0.0.0:80/calculate-price' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJVc2VyIERldGFpbHMiLCJpc3MiOiJZT1VSIEFQUExJQ0FUSU9OL1BST0pFQ1QvQ09NUEFOWSBOQU1FIiwiaWF0IjoxNjg5NDU0OTM2LCJlbWFpbCI6ImNvbXBhbnlAYXBwbGUuY29tIn0.CPajhyM6E1VJttxRWCAH2rsC7uOep2hrKHEUYnmo1Vk' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
"product": 1,
"couponCode": "percent",
"taxNumber": "FR123456789"
}'

