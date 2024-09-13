const numberOfGoalsInput = document.getElementById('number_of_goals');
const goalsContainer = document.querySelector('.goalcontainer'); // Select the correct container

numberOfGoalsInput.addEventListener('input', function() {
    const numberOfGoals = parseInt(numberOfGoalsInput.value);
    goalsContainer.innerHTML = ''; // Clear existing goals

    // Generate the required number of goal divs
    for (let i = 0; i < numberOfGoals; i++) {
        const goalDiv = document.createElement('div');
        goalDiv.classList.add('goal');
        goalDiv.innerHTML = `
            <label for="goal_name_${i}">Goal Name: </label> <input id="goal_name_${i}" type="text">
            <label for="goal_description_${i}">Goal Description: </label> <input id="goal_description_${i}" type="text">
            <label for="goal_points_${i}">End Goal Points: </label> <input id="goal_points_${i}" type="number" min="1">
        `;
        goalsContainer.appendChild(goalDiv);
    }
});

const createGroup = document.getElementById('createGroup');
createGroup.addEventListener('click', function() {
    const groupCode = document.getElementById('creatingGroup');
    const card = document.getElementById('card');


    if (groupCode.classList.contains('hide')) {
        groupCode.classList.remove('hide');
        card.classList.add('hide');
    }

});


const closebutton = document.getElementById('closeButton');
closebutton.addEventListener('click', function() {
    const groupCode = document.getElementById('creatingGroup');
    const card = document.getElementById('card');


    groupCode.classList.add('hide');
    card.classList.remove('hide');

});

function generateGroupCode(){
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    for (let i = 0; i < 9; i++) {
        result += characters.charAt(Math.floor(Math.random() * characters.length));
    }
    return result;
}





