#include <Stepper.h>

const int stepsPerRevolution = 200;  // Number of steps per revolution for the motor

int button1Pin = 14; // Button for indicating one direction
int button2Pin = 16; // Button for indicating the other direction

// Initialize the stepper library on specific pins
Stepper myStepper(stepsPerRevolution, 2, 0, 4, 5);

void setup() {
  // Initialize the serial port (for debugging)
  Serial.begin(9600);
  pinMode(button1Pin, INPUT);
  pinMode(button2Pin, INPUT);
}

void loop() {
  myStepper.setSpeed(60); // Set the speed of the stepper motor

  if (!digitalRead(button1Pin) && !digitalRead(button2Pin)) {
    bool run = true;
    unsigned long start = millis();
    while (run) {
      unsigned long checktime = millis();
      //This is going to have the program run forwared for 12 seconds
      if (13000 >= checktime - start  ){
        Serial.println("Moving Forward");
        myStepper.step(5);

      }
      //This is going ot have the program runthe motor backwards for 12 seconds
      else if(26000 >= checktime - start ){
        Serial.println("Moving bakwared");
        myStepper.step(-5);
      }
      //This ends the button loop 
      else{
        start = millis();
      }
      // This will stop the button program for an emergency
      if ((!digitalRead(button1Pin) == HIGH && !digitalRead(button2Pin) == LOW) || (!digitalRead(button1Pin) == LOW && !digitalRead(button2Pin) == HIGH)) {
        run = false;
      }


    }

  }


  else if (!digitalRead(button1Pin)) {
    // If button 1 is being pressed, move in the forward direction
    Serial.println("Moving Forward");
    myStepper.step(5);
  } 
  else if (!digitalRead(button2Pin)) {
    // If button 2 is being pressed, move in the backward direction
    Serial.println("Moving Backward");
    myStepper.step(-5);
  } 

}
