import mysql.connector
from mysql.connector import Error


def login(cursor):
    while True:
        email = input("Enter your email: ")
        password = input("Enter your password: ")

        # Query to find the user by email and password
        query = "SELECT user_id, name FROM user WHERE email = %s AND password = %s"
        cursor.execute(query, (email, password))

        result = cursor.fetchone()
        if result:
            user_id, name = result
            print(f"Login successful. Welcome, {name}!")
        else:
            print("Invalid email or password. Please try again.")

        return user_id, name

def main():
    try:
        # Establish the database connection
        connection = mysql.connector.connect(
            user='root',
            password='Bigdawg13$$$',
            database='group_goal'
        )

        if connection.is_connected():
            print("Connected to MySQL database")

            cursor = connection.cursor()  # Create a cursor object

            print("Hello, please select a number:")
            menu_choice = "0"
            while menu_choice not in ["1", "2"]:
                menu_choice = input("1. Login\n2. Register\nEnter: ")

            if menu_choice == "1":
                user_details = login(cursor)  # Call login function
                print(f"Logged in as: {user_details}")

            elif menu_choice == "2":
                print("Registration feature not implemented yet.")
                # Implement registration logic here

    except Error as e:
        print(f"Error: {e}")

    finally:
        if connection.is_connected():
            cursor.close()  # Close the cursor
            connection.close()  # Close the connection

if __name__ == "__main__":
    main()
