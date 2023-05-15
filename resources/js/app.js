/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

var moment = require('moment');

require('moment/locale/en-gb'); // locales all in lower-case

exports.install = function (Vue, options) {
    Vue.prototype.moment = function (...args) {
        return moment(...args);
    };

    Vue.prototype.route = function (...args) {
        return route(...args);
    };
}


window.Vue = require('vue');
window.NProgress = require('nprogress');

axios.interceptors.request.use(request => {
    NProgress.start()
    return request
})

axios.interceptors.response.use(response => {
    NProgress.done(true)
    return response
})

Vue.use(exports);

Vue.component('users-list', require('./components/UsersList.vue').default);
Vue.component('settings-list', require('../../Modules/Setting/Resources/components/SettingsList.vue').default);
Vue.component('doctors-list', require('../../Modules/Doctor/Resources/components/DoctorsList.vue').default);
Vue.component('services-list', require('../../Modules/Service/Resources/components/ServicesList.vue').default);
Vue.component('branches-list', require('../../Modules/Branch/Resources/components/BranchesList.vue').default);
Vue.component('offers-list', require('../../Modules/Offer/Resources/components/OffersList.vue').default);
Vue.component('bookings-list', require('../../Modules/Booking/Resources/components/BookingsList.vue').default);
Vue.component('blogs-list', require('../../Modules/Blog/Resources/components/BlogsList.vue').default);
Vue.component('comments-list', require('../../Modules/Comment/Resources/components/CommentsList.vue').default);
Vue.component('tickets-list', require('../../Modules/Ticket/Resources/components/TicketsList.vue').default);
Vue.component('sliders-list', require('../../Modules/Slider/Resources/components/SlidersList.vue').default);
Vue.component('testimonials-list', require('../../Modules/Testimonial/Resources/components/TestimonialsList.vue').default);
Vue.component('review-list', require('../../Modules/Review/Resources/components/ReviewList.vue').default);
Vue.component('question-list', require('../../Modules/Review/Resources/components/QuestionList.vue').default);
Vue.component('cases-list', require('../../Modules/Cases/Resources/components/CasesList.vue').default);
Vue.component('insurances-list', require('../../Modules/InsuranceCompany/Resources/components/InsurancesList.vue').default);
Vue.component('lectures-list', require('../../Modules/Lecture/Resources/components/LecturesList.vue').default);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('delete-modal', require('./components/modals/DeleteModal').default);
Vue.component('status-modal', require('./components/modals/StatusModal').default);
Vue.component('categories-list', require('../../Modules/Category/Resources/components/CategoriesList.vue').default);
Vue.component('contact-us', require('../../Modules/ContactUs/Resources/components/ContactUsList.vue').default);
Vue.component('subscription-form', require('../../Modules/SubscriptionForm/Resources/components/SubscriptionFormList.vue').default);
Vue.component('specializations-list', require('../../Modules/Specialization/Resources/components/SpecializationsList.vue').default);
Vue.component('frequently-asked-question-category-list', require('../../Modules/FrequentlyQuestion/Resources/components/FrequentlyAskedQuestionCategoryList.vue').default);
Vue.component('frequently-questions-list', require('../../Modules/FrequentlyQuestion/Resources/components/FrequentlyQuestion.vue').default);
Vue.component('redirection-list', require('../../Modules/Redirection/Resources/components/RedirectionList.vue').default);

Vue.use(exports);

const app = new Vue({
    delimiters: ['{(', ')}'],
    el: '#app'
});
