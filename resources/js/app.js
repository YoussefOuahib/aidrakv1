// import "bootstrap/dist/css/bootstrap.min.css"
// import './bootstrap';
// import "bootstrap/dist/js/bootstrap.min.js"
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import './guard'
import VueSweetalert2 from 'vue-sweetalert2'
import 'sweetalert2/dist/sweetalert2.min.css'
import router from './routes/index.js'
import {createApp, onMounted} from 'vue/dist/vue.esm-bundler.js'
import useAuth from "./Composables/auth"
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import '@mdi/font/css/materialdesignicons.css'
import { abilitiesPlugin } from '@casl/vue'
import ability from './services/ability'
import { createI18n } from 'vue-i18n'



const app = createApp({
    setup() {
        const { getUser } = useAuth()
        onMounted(getUser)
    }
})

const myLightTheme = {
  dark: false,
  colors: {
      background: "#E8E8E8",
      surface: "#E8E8E8",
      primary: "#499167",
      darkPrimary: "#016e2e",
      danger: "#B00020",
      "primary-darken-1": "#3700B3",
      secondary: "#6ECCAF",
      "secondary-darken-1": "#018786",
      "grey-backg" : "#F5F5F5",
      pink : "#a60058",
      darken: "#AAAAAA",
      error: "#B00020",
      info: "#2196F3",
      success: "#4CAF50",
      warning: "#3f0252",
  },
};
const myDarkTheme = {
  dark: true,
  colors: {
      background: "#393939",
      surface: "#393939",
      primary: "#68B984",
      darkPrimary: "#07D698",
      danger: "#E97777",
      "primary-darken-1": "#3700B3",
      secondary: "#6ECCAF",
      "secondary-darken-1": "#07BBDE",
      pink : "#FD80E0",
      "grey-backg" : "#393939",
      darken: "#AAAAAA",
      error: "#B00020",
      info: "#2196F3",
      success: "#4CAF50",
      warning: "#FED049",
  },
};


const vuetify = createVuetify({
  theme: {
    defaultTheme: localStorage.getItem('userTheme') || 'myLightTheme',
    themes: {
      myLightTheme,
      myDarkTheme,
    }
  },
  components,
  directives,
})

const messages = {
  en: {
    message: {
      home: 'Home',
      name: 'Name',
      fullName: 'Full name',
      invoice: 'Invoice',
      thisMonth: 'This month',
      month: 'Month',
      totalIncome: 'Total income',
      lastWeek : 'Last week',
      generateInvoice: 'generate invoice',
      invoices: 'Invoices',
      print : 'Print',
      paidAmount: 'Paid amount',
      remainingAmount: 'Remaining amount',
      appointments: 'Appointments',
      appointment: 'Appointment',
      sessions: 'Sessions',
      session: 'Session',
      phone: 'Phone',
      firstAppointment: 'First appointment',
      upcomingAppointments: 'Upcoming appointments',
      save: 'Save',
      close: 'Close',
      act: 'Act',
      acts: 'Medical Acts',
      diagnostic: 'Diagnostic',
      addAppointment: 'New appointment',
      addPatient: 'New patient',
      paid: 'Paid',
      unpaid: 'Unpaid',
      upcomingAppointment: 'Upcoming appointment',
      medicalTreatment: 'medical treatment',
      additionalNote: 'Additional note',
      nextExaminationDate: 'Next appointment',
      selectNextExaminationDate: 'Select next examination date',
      selectBirthDate: 'Select birth date',
      totalAmountTreatment: 'Total amount Of treatment',
      sessionsNumber: 'Total number of sessions',
      uncofirmed: 'Uncofirmed',
      confirmed: 'Confirmed',
      status: 'Status',
      amount: 'Amount',
      insurance: 'Insurance',
      linkCondition: 'Link condition',
      settings: 'Settings',
      speciality: 'Speciality',
      address: 'address',
      fixedRate: 'Fixed Rate',
      rate: 'Rate',
      none: 'None',
      yearsOld: 'Years old',
      addCondition: 'Add Condition',
      addAct: "Add an acte",
      numberOfPatients: 'Patients',
      logOut: 'Log Out',
      currentPw: 'Current password',
      newPw: 'New password',
      repeatNewPw: 'Repeat new password',
      changePassword: 'Change Password',
      changePasswordRec: 'Change receptionist password',
      setting1: 'the price of medical consultation is fixed',
      search: 'Search by name or CIN',

    }
  },
  fr: {
    message: {
      home: 'Accueil',
      name: 'Nom',
      fullName: 'Nom Complet',
      invoices: 'Factures',
      invoice: 'Facture',
      thisMonth: 'Ce mois-ci',
      month: 'Mois',
      totalIncome: 'Revenu total',
      lastWeek : 'Semaine dernière',
      print: 'Imprimer',
      appointment: 'Rendez-vous',
      appointments: 'Rendez-Vous',
      sessions: 'Séances',
      session: 'Séance',
      act: 'Acte',
      acts: 'Actes médicaux',
      diagnostic: 'Diagnostique',
      addPatient: 'Nouveau Patient',
      phone: 'Téléphone',
      firstAppointment: 'Premier rendez-vous',
      save: 'Sauvegarder',
      close: 'Fermer',
      addAppointment: 'Ajouter un rendez-vous',
      paid: 'Payé',
      remainingAmount: 'Montant restant',
      paidAmount: 'Montant payé',
      unpaid: 'Non payé',
      upcomingAppointment: 'Rendez-vous à venir',
      upcomingAppointments: 'Rendez-vous à venir',
      medicalTreatment: 'Traitment médical',
      additionalNote: 'Remarque additionelle',
      selectNextExaminationDate: 'Sélectionnez la date du prochain Rendez-vous',
      selectBirthDate: 'sélectionnez la date de naissance',
      nextExaminationDate: 'prochain rendez-vous',
      totalAmountTreatment: 'Montant total du traitement',
      sessionsNumber: 'Nombre de séances',
      uncofirmed: 'Non confirmé',
      confirmed: 'Confirmé',
      status: 'statut',
      amount: 'Montant',
      linkCondition: 'Associer',
      settings: 'Réglages',
      speciality: 'Specialité',
      address: 'adresse',
      fixedRate: 'Prix fixe',
      insurance: 'Assurance',
      rate: 'Prix',
      yearsOld: 'ans',
      none: 'Aucun',
      addCondition: 'Ajouter une condition',
      addAct: 'Ajouter un act médical',
      numberOfPatients: 'Patients',
      generateInvoice: 'générer une facture',
      logOut: 'Déconnexion',
      currentPw: 'Mot de passe actuel',
      newPw: 'Nouveau mot de passe',
      repeatNewPw: 'Répété le nouveau mot de passe',
      changePassword: 'Changer mot de passe',
      changePasswordRec: 'Changer le mot de passe de la réceptionniste',
      setting1: 'le prix de la consultation médicale est fixe ',
      search: 'Rechercher par nom ou CIN',




    }
  }
}
const i18n = createI18n({
  locale:  localStorage.getItem('userLanguage') || 'en', // set locale
  fallbackLocale: 'fr', // set fallback locale
  messages, // set locale messages
  // If you need to specify other options, you can set other options
  // ...
})
app.component('Bootstrap5Pagination', Bootstrap5Pagination)
app.use(abilitiesPlugin, ability)

app.use(VueSweetalert2)
app.use(router)
app.use(i18n)

app.use(vuetify).mount('#app')
