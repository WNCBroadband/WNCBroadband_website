from google.cloud import bigquery
import os
from datetime import datetime
import pymysql

print("Bigquery and PyMySQL imported")
# connecting to BigQuery
print("Exporting BigQuery Credentials")
os.environ["GOOGLE_APPLICATION_CREDENTIALS"] = "westngn-256318-b53ec54b351a.json"
print("Verifying Credentials")

# now to connect to the mysql database
print("Connecting to MySQL Database")

db = pymysql.connect(
  host="138.68.228.126",
  user="drawertl_westngn",
  passwd="dbpass_adh4enal",
  database="drawertl_westngn"
)

print("Connected to database: drawertl_westngn, Creating cursor object.")

cursor = db.cursor()

print("Cursor created.")


# back to bigquery
client = bigquery.Client()
print("Running Query")

query_job = client.query("""
    SELECT
        ndt5.result.S2C.MeanThroughputMbps AS download_Mbps,
        IFNULL(ndt5.result.C2S.MeanThroughputMbps,0.0) AS upload_Mbps,


        tcpinfo.Client.Geo.latitude AS client_lat, 
        tcpinfo.Client.Geo.longitude AS client_lon,
        ndt5.result.ClientIP AS client_ip,
        log_time,
        FORMAT_TIMESTAMP("%F %X",TIMESTAMP_SECONDS(ndt5.log_time), "UTC") AS client_test_time,
        ndt5.ParseInfo.TaskFileName AS test_id 
    FROM
        `measurement-lab.ndt.ndt5` ndt5,
        `measurement-lab.ndt.tcpinfo` tcpinfo
    WHERE
        ndt5.partition_date BETWEEN '2020-04-01' AND \'""" + str(datetime.today().strftime('%Y-%m-%d')) + """\'
        AND ndt5.result.S2C.UUID = tcpinfo.UUID
        AND (tcpinfo.Client.Geo.latitude BETWEEN 35.20 AND 35.80)
        AND (tcpinfo.Client.Geo.longitude BETWEEN -82.80 AND -82.20)
""")

print("Query Made, Fetching Results")
    
results = query_job.result()  # Waits for job to complete.

print("Query Results Fetched")

#now
i = 0
for row in results:
    i = i + 1

#print("|IP({}) |:| Download({}Mbps)|:| Upload({}Mbps) |:| Coords({},{}) |:| Time({}) |:| Test_ID({})|\n".format(row.client_ip, row.download_Mbps, row.upload_Mbps, row.client_lat, row.client_lon, row.client_test_time, row.test_id))

    values = ("\'{}\', \'{}\', \'{}\', {}, {}, {}, {}".format(row.client_ip, row.test_id, row.client_test_time, row.client_lat, row.client_lon, row.download_Mbps, row.upload_Mbps,))
    print("Inserting query result " + str(i) + " into the MLABS_speed_data table")
#    print("values = " + values + "\n")

# Prepare SQL query to INSERT a record into the database.
    sql = """INSERT INTO MLABS_speed_data(
        ip_address,
         mlabs_test_id,
         date_taken,
         latitude,
         longitude,
         download_speed,
         upload_speed
         )
         VALUES (""" + values + """)"""
#    print(sql)
    
    
    try:
       # Execute the SQL command
       cursor.execute(sql)
       # Commit your changes in the database
       db.commit()
       print("\nINSERT success!")
    except:
       # Rollback in case there is any error
       db.rollback()
       print("\n*** ERROR ***\n INSERT FAILED \n*** ERROR ***\n")

print("accessing table MLABS_speed_data...")

cursor.execute("SELECT * FROM MLABS_speed_data")

table_result = cursor.fetchall()

print("Table MLABS_speed_data fetched. Now printing the table...")

#for x in table_result:
#  print(x)

print("Process Complete.")

db.close()
