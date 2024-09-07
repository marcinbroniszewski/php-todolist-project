const panelBtn = document.getElementById('panel');
const settingsBtn = document.getElementById('settings');
const logoutBtn = document.getElementById('logout');
const dashboardNavLinks = document.querySelectorAll('.dashboard-nav-link');
const settingsSection = document.querySelector('.settings-section');
const dashboardNavBtn = document.querySelector('.dashboard-nav-btn');
const dashboardNavBox = document.querySelector('.dashboard-nav-box');
const backShadow = document.querySelector('.back-shadow');

const dashboardNavToggle = () => {
	if (backShadow.classList.contains('active') && dashboardNavBox.classList.contains('active')) {
		backShadow.classList.remove('active');
		dashboardNavBox.classList.remove('active');
	} else {
		backShadow.classList.add('active');
		dashboardNavBox.classList.add('active');
	}
};

const closeDashboardNav = () => { 
	backShadow.classList.remove('active');
	dashboardNavBox.classList.remove('active');
 }

const openSettingsWindow = () => {
	if (settingsSection.classList.contains('d-none')) {
		const currentActiveLink = Array.from(dashboardNavLinks).find(element => element.classList.contains('active'));
		currentActiveLink.classList.remove('active');

		settingsBtn.classList.add('active');
		settingsSection.classList.remove('d-none');
      
            closeDashboardNav()
	}

};
const openPanelWindow = () => {
    if (!settingsSection.classList.contains('d-none')) {
	const currentActiveLink = Array.from(dashboardNavLinks).find(element => element.classList.contains('active'));
	currentActiveLink.classList.remove('active');

	panelBtn.classList.add('active');
    settingsSection.classList.add('d-none');

	closeDashboardNav()
	}
};

const logoutHandler = () => {
	const currentActiveLink = Array.from(dashboardNavLinks).find(element => element.classList.contains('active'));
	currentActiveLink.classList.remove('active');

	logoutBtn.classList.add('active');

	fetch('/user/logout', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
		},
		body: 'logout',
	})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				window.location.href = '/';
			} else {
				console.error('Wystąpił błąd w skrypcie PHP.');
			}
		})
		.catch(error => {
			console.error('Wystąpił błąd:', error);
		});
};

dashboardNavBtn.addEventListener('click', dashboardNavToggle);
backShadow.addEventListener('click', dashboardNavToggle);
settingsBtn.addEventListener('click', openSettingsWindow);
panelBtn.addEventListener('click', openPanelWindow);
logoutBtn.addEventListener('click', logoutHandler);