
function loadCSV(url) {
    return new Promise((resolve, reject) => {
      Papa.parse(url, {
        download: true,
        header: true,
        complete: function (results) {
          console.log('Parsed CSV:', results.data);
          resolve(results.data);
        },
        error: function (error) {
          console.error('Error parsing CSV:', error);
          reject(error);
        }
      });
    });
  }

  async function checkAnswers() {
    try {
      const actualAnswers = await loadCSV('actual_answers.csv');
      const submittedAnswers = await loadCSV('submitted_answers.csv');

      console.log('Actual Answers:', actualAnswers);
      console.log('Submitted Answers:', submittedAnswers);


      const tableBody = document.createElement('tbody');
      let correctCount = 0;

      const totalQuestions = Math.min(actualAnswers.length, submittedAnswers.length);

      for (let i = 0; i < totalQuestions; i++) {
        const row = document.createElement('tr');


        const questionCell = document.createElement('td');
        questionCell.textContent = i + 1;


        const actualAnswerCell = document.createElement('td');
        actualAnswerCell.textContent = actualAnswers[i].Answer || '';


        const submittedAnswerCell = document.createElement('td');
        submittedAnswerCell.textContent = submittedAnswers[i].Answer || '';


        if (actualAnswers[i].Answer === submittedAnswers[i].Answer) {
          correctCount++;
        }

        row.appendChild(questionCell);
        row.appendChild(actualAnswerCell);
        row.appendChild(submittedAnswerCell);
        tableBody.appendChild(row);
      }


      const answerTable = document.getElementById('answerTable');

      const oldTbody = answerTable.querySelector('tbody');
      if (oldTbody) oldTbody.remove();
      answerTable.appendChild(tableBody);


      const scoreElement = document.getElementById('score');
      scoreElement.textContent = `Score: ${correctCount}/${totalQuestions}`;
    } catch (error) {
      console.error('Error checking answers:', error);
    }
  }


  document.addEventListener('DOMContentLoaded', checkAnswers);
