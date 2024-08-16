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
    
def is_not_empty(string):
    while True:
        if len(string.strip()) > 0:
            return string
        else:
            string = input("Please enter a valid input: ")

def create_account(cursor):
    #this is where the user is going ot creat an account they will need to enter an email and password

    email = is_not_empty(input("Enter your email: "))
    name = is_not_empty(input("Enter your name: "))
    while True:
        print("You password must be at least 8 characters long.\n1. Include at least one uppercase letter")
        print(".\n2. Include at least one lowercase letter.\n3. Include at least one number.\n4. Include at least one special character.\n")
        print("special characters include: !\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~")

        password = input("Enter your password: ")

        password_verification = input("Verify your password: ")
        if password == password_verification and password_check(password) == True:
            break
    
    query = "INSERT INTO user (email, name, password) VALUES (%s, %s, %s)"
    cursor.execute(query, (email, name, password))
    mydb.commit()  
    return
    


def password_check(password):
    # Criteria arrays
    num = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"]
    spec_chr = ["!", "\"", "#", "$", "%", "&", "'", "(", ")", "*", "+", ",", "-", ".", "/", ":", ";", "<", "=", ">", "?", "@", "[", "\\", "]", "^", "_", "`", "{", "|", "}", "~"]
    lower = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"]
    upper = ["A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"]

    # Initialize flags
    haslength = False
    hasupper = False
    haslower = False
    hasnumber = False
    hasSpecial = False

    # Password validation loop
    password = input("Enter your password: ")

    for char in password:
        if char in num:
            hasnumber = True
        if char in lower:
            haslower = True
        if char in upper:
            hasupper = True
        if char in spec_chr:
            hasSpecial = True

    # Check the length requirement
    if len(password) >= 8:
        haslength = True

    # Summary of the validation
    if haslength:
        if hasupper:
            if haslower:
                if hasnumber:
                    if hasSpecial:
                        return True
                    else:
                        print("Password is invalid. It must include at least one special character.")
                else:
                    print("Password is invalid. It must include at least one number.")
            else:
                print("Password is invalid. It must include at least one lowercase letter.")
        else:
            print("Password is invalid. It must include at least one uppercase letter.")
    else:
        print("Password is invalid. It must be at least 8 characters long.")

    return False


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
                menu_choice = input("\n1. Login\n2. Register\nEnter: ")

            if menu_choice == "1":
                user_id, name = login(cursor)  # Call login function

                # Perform database operations based on user_id


            elif menu_choice == "2":
                create_account(cursor)
                print("Registration successful. You can now login.")
                user_id, name = login(cursor)
            
            print(user_id, name)

    except Error as e:
        print(f"Error: {e}")

    finally:
        if connection.is_connected():
            cursor.close()  # Close the cursor
            connection.close()  # Close the connection

if __name__ == "__main__":
    main()
