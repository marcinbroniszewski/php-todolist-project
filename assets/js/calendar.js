const monthYearDate = document.querySelector(".month-year");
const numericDays = document.querySelector(".numeric-days");
const prevMonthBtn = document.querySelector(".prev-month-btn");
const nextMonthBtn = document.querySelector(".next-month-btn");

let date, year, month, day, currentMonth;

async function fetchDataFromSession() {
  try {
    const response = await fetch("/api/get-date");

    if (!response.ok) {
      throw new Error("Błąd pobierania danych: " + response.status);
    }

    const data = await response.json();

    if (data.error) {
      console.error(data.error);
    } else {
      [year, month, day] = data.date.split("-");
      year = Number(year);
      month = Number(month);
      day = Number(day);
      currentMonth = Number(month);
      createCalendar(year, month, day);
    }
  } catch (error) {
    console.error("Błąd pobierania danych:", error.message);
  }
}

fetchDataFromSession();

const setMonthYearDate = (year, month, day = null) => {
  if (day) {
    const dayDate = document.querySelector(".day-date");

    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth() + 1;
    const currentDay = currentDate.getDate();

    if (year === currentYear && month === currentMonth && day === currentDay) {
      dayDate.textContent = "Dzisiaj, " + day;
    } else if (
      year === currentYear &&
      month === currentMonth &&
      day === currentDay - 1
    ) {
      dayDate.textContent = "Wczoraj, " + day;
    } else if (
      year === currentYear &&
      month === currentMonth &&
      day === currentDay + 1
    ) {
      dayDate.textContent = "Jutro, " + day;
    } else {
      const date = new Date(year, month - 1, day);
      const dayOfWeek = date.getDay();
      const daysOfWeek = [
        "Niedziela",
        "Poniedziałek",
        "Wtorek",
        "Środa",
        "Czwartek",
        "Piątek",
        "Sobota",
      ];
      dayDate.textContent = `${daysOfWeek[dayOfWeek]}, ${day}`;
    }
  }

  const monthNames = [
    "Styczeń",
    "Luty",
    "Marzec",
    "Kwiecień",
    "Maj",
    "Czerwiec",
    "Lipiec",
    "Sierpień",
    "Wrzesień",
    "Październik",
    "Listopad",
    "Grudzień",
  ];
  const monthName = monthNames[month - 1];
  monthYearDate.innerHTML = `${monthName} ${year}`;
};

const createCalendar = (year, month, selectedDay = null) => {
  setMonthYearDate(year, month, selectedDay);

  let firstDay = new Date(year, month - 1, 1).getDay();
  firstDay === 0 && (firstDay = 7);
  const lastDay = new Date(year, month, 0).getDate();
  const lastDayOfLastMonth = new Date(year, month - 1, 0).getDate();

  let tableHTML = "<tr>";

  const startPrevMonthDay = lastDayOfLastMonth - firstDay + 2;

  let dayCounter = 0;
  //Dodawanie dni z poprzedniego miesiąca
  for (let i = startPrevMonthDay; i <= lastDayOfLastMonth; i++) {
    if (dayCounter === 7) {
      tableHTML += "</tr><tr>";

      dayCounter = 0;
    }

    tableHTML += `<td class="prev-month-day date">${i}</td>`;

    dayCounter++;
  }
  //Dodawanie dni z aktualnego miesiąca
  for (let i = 1; i <= lastDay; i++) {
    if (dayCounter === 7) {
      tableHTML += "</tr><tr>";

      dayCounter = 0;
    }

    if (i === selectedDay) {
      tableHTML += `<td class="date active">${i}</td>`;
    } else {
      tableHTML += `<td class="date">${i}</td>`;
    }
    dayCounter++;
  }
  //	Dodawanie dni z nastepnego miesiąca
  if (dayCounter !== 0) {
    const leftDays = 7 - dayCounter;

    for (let i = 1; i <= leftDays; i++) {
      tableHTML += `<td class="next-month-day date">${i}</td>`;

      dayCounter++;
    }
    dayCounter = 0;
  }

  tableHTML += "</tr></tbody></table>";
  numericDays.innerHTML = tableHTML;

  //Ustawianie listenerów na daty
  const tdElements = document.querySelectorAll(".date");
  tdElements.forEach((td) =>
    td.addEventListener("click", (e) => selectDate(year, month, e))
  );
};

//Wybieranie innych miesięcy
const selectPrevMonth = () => {
  // 	let storedDate = JSON.parse(localStorage.getItem('storedDate')) || { year, month };
  // const selectedDate = JSON.parse(localStorage.getItem('selectedDate'))
  if (month === 1) {
    month = 12;
    year--;
  } else {
    month--;
  }

  // localStorage.setItem('storedDate', JSON.stringify(storedDate));
  createCalendar(year, month);

  if (month === currentMonth) {
    setActiveDate(day);
  }
};

const selectNextMonth = () => {
  if (month === 12) {
    month = 1;
    year++;
  } else {
    month++;
  }

  // localStorage.setItem('storedDate', JSON.stringify(storedDate));
  createCalendar(year, month);

  if (month === currentMonth) {
    setActiveDate(day);
  }
};

// Ustawienie aktywnej daty jeśli wybrany miesiąc jest równy aktualnemu
const setActiveDate = (selectedDay) => {
  const tdElements = document.querySelectorAll(".date");
  const tdArray = Array.from(tdElements);

  const tdActive = tdArray.find(
    (td) =>
      td.textContent === selectedDay.toString() &&
      !td.classList.contains("prev-month-day") &&
      !td.classList.contains("next-month-day")
  );

  if (tdActive) {
    tdActive.classList.add("active");
  }
};

//Wybieranie zadań z innej daty
const selectDate = (year, month, e) => {
  let day = Number(e.target.textContent);

  if (e.target.classList.contains("next-month-day") && month === 12) {
    month = 1;
    year++;
  } else if (e.target.classList.contains("next-month-day")) {
    month++;
  } else if (e.target.classList.contains("prev-month-day") && month === 1) {
    month = 12;
    year--;
  } else if (e.target.classList.contains("prev-month-day")) {
    month--;
  }
  const date = `${year}-${month}-${day}`;

  sendDateData(date);
};

//Wysyłanie danych
const sendDateData = (date) => {
  fetch("api/send-date", {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: "date=" + date,
  })
    .then(() => location.reload())
    .catch((error) => {
      console.error("Wystąpił błąd:", error);
    });
};

//addEventListener'y
prevMonthBtn.addEventListener("click", selectPrevMonth);
nextMonthBtn.addEventListener("click", selectNextMonth);
