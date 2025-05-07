

    <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>Expenses Tracker - Dark Mode</title>
<style>
  /* Base resets and dark mode styling */
  * {
    box-sizing: border-box;
  }
  body {
    margin: 0;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    background-color: #121212;
    color: #e0e0e0;
    display: flex;
    justify-content: center;
    padding: 10px;
    height: 100vh;
    overflow: hidden;
  }
  #app {
    background-color: #1e1e1e;
    width: 100%;
    max-width: 350px;
    max-height: 600px;
    border-radius: 14px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.7);
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }
  header {
    padding: 18px;
    font-size: 1.7rem;
    font-weight: 700;
    text-align: center;
    border-bottom: 1px solid #333;
    color: #4db6ac;
  }
  form {
    padding: 15px 20px;
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    background-color: #272727;
    border-bottom: 1px solid #333;
    border-radius: 0 0 14px 14px;
  }
  form input, form select {
    padding: 10px 12px;
    font-size: 1rem;
    border: none;
    border-radius: 8px;
    flex-grow: 1;
    color: #222;
  }
  form input[type="text"], form input[type="number"], form input[type="date"] {
    flex-basis: 100%;
  }
  form button {
    background-color: #4db6ac;
    color: #121212;
    font-weight: 700;
    border: none;
    padding: 12px;
    flex-basis: 100%;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.1rem;
    transition: background-color 0.25s ease;
  }
  form button:hover {
    background-color: #339a91;
  }
  main {
    flex: 1;
    overflow-y: auto;
    padding: 0 10px 10px 10px;
  }
  #expenses-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 12px;
  }
  #expenses-table thead {
    border-bottom: 2px solid #4db6ac;
  }
  #expenses-table th, #expenses-table td {
    padding: 8px 8px;
    text-align: left;
    font-size: 0.9rem;
  }
  #expenses-table th {
    font-weight: 700;
    color: #4db6ac;
  }
  #expenses-table tbody tr:nth-child(even) {
    background-color: #292929;
  }
  #expenses-table tbody tr:hover {
    background-color: #3a3a3a;
  }
  .btn-delete {
    background: none;
    border: none;
    color: #f44336;
    font-size: 1.3rem;
    cursor: pointer;
    padding: 0;
    line-height: 1;
    transition: color 0.3s ease;
  }
  .btn-delete:hover {
    color: #ba000d;
  }
  footer {
    background-color: #272727;
    color: #4db6ac;
    font-weight: 700;
    font-size: 1.3rem;
    padding: 15px 20px;
    border-top: 1px solid #333;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  #chart-container {
    margin-top: 8px;
    padding: 10px;
    background-color: #222;
    border-radius: 10px;
  }
  canvas {
    width: 100% !important;
    height: 150px !important;
  }
  @media (max-width: 400px) {
    #app {
      max-width: 100vw;
      border-radius: 0;
      height: 100vh;
      max-height: 600px;
    }
    form input[type="text"],
    form input[type="number"],
    form input[type="date"],
    form button {
      flex-basis: 100%;
    }
  }
</style>
</head>
<body>
<div id="app">
  <header>Expenses Tracker</header>
  <form id="expense-form" aria-label="Add new expense form" novalidate>
    <input type="text" id="description" placeholder="Description" aria-label="Expense description" required autocomplete="off" />
    <input type="number" id="amount" placeholder="Amount" min="0.01" step="0.01" aria-label="Expense amount" required />
    <input type="date" id="date" aria-label="Expense date" required />
    <button type="submit">Add Expense</button>
  </form>
  <main>
    <table id="expenses-table" aria-label="List of expenses">
      <thead>
        <tr>
          <th>Date</th>
          <th>Description</th>
          <th>Amount</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <!-- Expenses will appear here -->
      </tbody>
    </table>
    <div id="chart-container" aria-label="Monthly Expense Chart">
      <canvas id="expense-chart" role="img" aria-describedby="chart-description"></canvas>
      <div id="chart-description" style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">Bar chart showing monthly expenses totals</div>
    </div>
  </main>
  <footer>
    <span>Total:</span>
    <span id="total-amount">$0.00</span>
  </footer>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(() => {
  const form = document.getElementById('expense-form');
  const descriptionEl = document.getElementById('description');
  const amountEl = document.getElementById('amount');
  const dateEl = document.getElementById('date');
  const tableBody = document.querySelector("#expenses-table tbody");
  const totalAmountEl = document.getElementById('total-amount');
  const ctx = document.getElementById("expense-chart").getContext("2d");

  let expenses = [];

  function loadExpenses() {
    const saved = localStorage.getItem("expenses");
    if (saved) {
      try {
        expenses = JSON.parse(saved);
      } catch {
        expenses = [];
      }
    } else {
      expenses = [];
    }
  }

  function saveExpenses() {
    localStorage.setItem("expenses", JSON.stringify(expenses));
  }

  function formatDate(dateStr) {
    const d = new Date(dateStr);
    if (isNaN(d)) return "";
    return d.toLocaleDateString(undefined, {year: "numeric", month: "short", day: "numeric"});
  }

  function renderTable() {
    tableBody.innerHTML = "";
    expenses.forEach((expense, index) => {
      const tr = document.createElement("tr");

      const tdDate = document.createElement("td");
      tdDate.textContent = formatDate(expense.date);
      tr.appendChild(tdDate);

      const tdDesc = document.createElement("td");
      tdDesc.textContent = expense.description;
      tr.appendChild(tdDesc);

      const tdAmount = document.createElement("td");
      tdAmount.textContent = `$${Number(expense.amount).toFixed(2)}`;
      tdAmount.style.color = "#4db6ac";
      tdAmount.style.fontWeight = "700";
      tr.appendChild(tdAmount);

      const tdDel = document.createElement("td");
      const btnDel = document.createElement("button");
      btnDel.className = "btn-delete";
      btnDel.title = `Delete expense: ${expense.description} $${Number(expense.amount).toFixed(2)}`;
      btnDel.innerHTML = "&times;";
      btnDel.type = "button";
      btnDel.addEventListener("click", () => {
        removeExpense(index);
      });
      tdDel.appendChild(btnDel);
      tr.appendChild(tdDel);

      tableBody.appendChild(tr);
    });
    updateTotal();
    updateChart();
  }

  function updateTotal() {
    const total = expenses.reduce((sum, e) => sum + Number(e.amount), 0);
    totalAmountEl.textContent = `$${total.toFixed(2)}`;
  }

  function addExpense(description, amount, date) {
    expenses.push({ description, amount: Number(amount), date });
    saveExpenses();
    renderTable();
  }

  function removeExpense(index) {
    expenses.splice(index, 1);
    saveExpenses();
    renderTable();
  }

  // Chart.js bar chart instance
  let expenseChart = null;
  function updateChart() {
    // Aggregate expenses by month (YYYY-MM)
    const monthlyTotals = {};
    expenses.forEach(({date, amount}) => {
      if (!date) return;
      const d = new Date(date);
      if (isNaN(d)) return;
      const key = d.getFullYear() + "-" + String(d.getMonth()+1).padStart(2, '0');
      monthlyTotals[key] = (monthlyTotals[key] || 0) + Number(amount);
    });

    // Sort months ascending
    const months = Object.keys(monthlyTotals).sort();

    const labels = months.map(m => {
      const [y, mm] = m.split("-");
      const dt = new Date(y, mm-1);
      return dt.toLocaleDateString(undefined, {year:"numeric", month:"short"});
    });
    const data = months.map(m => monthlyTotals[m]);

    if (expenseChart) {
      expenseChart.data.labels = labels;
      expenseChart.data.datasets[0].data = data;
      expenseChart.update();
    } else {
      expenseChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels,
          datasets: [{
            label: 'Monthly Expenses',
            data,
            backgroundColor: '#4db6ac',
            borderRadius: 4,
          }]
        },
        options: {
          responsive: true,
          animation: {duration: 500},
          scales: {
            x: { 
              grid: {display: false},
              ticks: {color: '#b2dfdb'}
            },
            y: {
              beginAtZero: true,
              ticks: {color: '#b2dfdb'},
              grid: {color: '#333'}
            }
          },
          plugins: {
            legend: {labels: {color: '#b2dfdb'}},
            tooltip: {mode: 'index', intersect: false},
          }
        }
      });
    }
  }

  form.addEventListener("submit", e => {
    e.preventDefault();
    const description = descriptionEl.value.trim();
    const amount = amountEl.value.trim();
    const date = dateEl.value;

    if (!description) {
      alert("Enter a description");
      descriptionEl.focus();
      return;
    }
    if (!amount || isNaN(amount) || Number(amount) <= 0) {
      alert("Enter valid amount > 0");
      amountEl.focus();
      return;
    }
    if (!date) {
      alert("Select a date");
      dateEl.focus();
      return;
    }

    addExpense(description, amount, date);
    form.reset();
    descriptionEl.focus();
  });

  function setDateToday() {
    const today = new Date().toISOString().split("T")[0];
    dateEl.value = today;
    dateEl.max = today;
  }

  function init() {
    loadExpenses();
    renderTable();
    setDateToday();
  }

  init();
})();
</script>
</body>
</html>



    
</body>
</html>