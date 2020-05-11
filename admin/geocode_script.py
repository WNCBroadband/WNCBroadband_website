import bs4
import json
from urllib.parse import quote_plus as urlEncode
from urllib.request import urlopen as uReq


#This script is a geocoder! Run it in Command Prompt and type in an address. It will spit out coordinates in (Lat, Long) form! Good Luck!

streetAddress = str(input())
encodedAddress = urlEncode(streetAddress)
key = "AIzaSyBlAwxc91arMg6vYn1pMyzt_an5E4EAD6g" #black this out

my_url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' + encodedAddress + '&key=' + key

#print(my_url)

soup = json.load(uReq(my_url))

resultsList = soup.get('results')

resultsDict = next(item for item in resultsList)

print("(" + str(resultsDict.get("geometry").get("location")["lat"]) + ", " + str(resultsDict.get("geometry").get("location")["lng"]) + ")")
