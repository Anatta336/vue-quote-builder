<template>
    <div>
        <p>
            Send this quote as an email to {{ quote.customer_email }}:
            <button :disabled="!!isAwaitingEmailSend || !quote || !quote.customer_email" @click="sendEmail">Email</button>
        </p>
        <p v-if="emailFeedback != ''">{{ emailFeedback }}</p>
    </div>
</template>
<script>
export default {
    name: 'quote-email',
    props: {
        quote: {
            type: Object,
            required: true,
            validator(value) {
                return value.hasOwnProperty('id')
                    && value.hasOwnProperty('customer_name')
                    && value.hasOwnProperty('customer_email');
            },
        },
    },
    data() {
        return {
            isAwaitingEmailSend: false,
            emailFeedback: false,
        }
    },
    methods: {
        async sendEmail() {
            this.isAwaitingEmailSend = true;
            this.emailFeedback = 'Sending email...';
            try {
                await axios.post(`/api/quotes/${this.quote.id}/email`);

                this.isAwaitingEmailSend = false;
                const date = new Date();
                this.emailFeedback = 'Email sent (UTC) '
                    + date.getUTCFullYear()
                    + "/" + (date.getUTCMonth() + 1)
                    + "/" + date.getUTCDate()
                    + " at " + date.getUTCHours()
                    + ":" + date.getUTCMinutes()
                    + ":" + date.getUTCSeconds();
            } catch (error) {
                console.warn(error);
                this.emailFeedback = 'An error occurred when attempting to send as email.';
            }
        }
    }
}
</script>