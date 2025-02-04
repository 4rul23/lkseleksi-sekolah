(async function() {
  async function loadCSV(url) {
    try {
      const response = await fetch(url);
      if (!response.ok) {
        throw new Error(`Fetch failed with status: ${response.status}`);
      }
      const csvText = await response.text();
      return csvText.trim().split('\n').map(row => row.split(','));
    } catch (error) {
      console.error('Error fetching CSV:', error);
      throw error;
    }
  }

  async function checkAnswers() {
    try {

      const actualAnswersRaw = await loadCSV('a.csv');
      const submittedAnswersRaw = await loadCSV('b.csv');

      const actualAnswers = actualAnswersRaw;
      const submittedAnswers = submittedAnswersRaw;

      console.log('Actual Answers:', actualAnswers);
      console.log('Submitted Answers:', submittedAnswers);

      const tableBody = document.querySelector('#resultsTable tbody');
      if (!tableBody) {
        console.error('Could not find tbody in #resultsTable');
        return;
      }

      const totalCount = Math.max(actualAnswers.length, submittedAnswers.length);
      let correctCount = 0;

      for (let i = 0; i < totalCount; i++) {
        const question = `Question ${i + 1}`;
        const actualAnswer = actualAnswers[i] && actualAnswers[i][0] ? actualAnswers[i][0] : '';
        const submittedAnswer = submittedAnswers[i] && submittedAnswers[i][0] ? submittedAnswers[i][0] : '';

        if (actualAnswer.trim() === submittedAnswer.trim()) {
          correctCount++;
        }

        const tr = document.createElement('tr');

        const tdQuestion = document.createElement('td');
        tdQuestion.textContent = question;

        const tdActual = document.createElement('td');
        tdActual.textContent = actualAnswer;

        const tdSubmitted = document.createElement('td');
        tdSubmitted.textContent = submittedAnswer;

        tr.append(tdQuestion, tdActual, tdSubmitted);
        tableBody.appendChild(tr);
      }

      const scoreElement = document.getElementById('score');
      scoreElement.textContent = `Score: ${correctCount} / ${totalCount}`;
    } catch (error) {
      console.error('Error in checkAnswers:', error);
    }
  }

  checkAnswers();
})();
