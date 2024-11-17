<template>
    <div>
        <div v-for="message in messages" :key="message.id">
            <strong>{{ message.sender.name }}:</strong> {{ message.message }}
        </div>
        <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Type a message..." />
    </div>
</template>

<script>
export default {
    data() {
        return {
            messages: [],
            newMessage: '',
        };
    },
    mounted() {
        this.fetchMessages();
        // Listen for messages on the private channel
        window.Echo.private(`chat.${this.$route.params.userId}`)
            .listen('MessageSent', (e) => {
                this.messages.push(e.message);
            });
    },
    methods: {
        fetchMessages() {
            axios.get(`/api/messages/${this.$route.params.userId}`)
                .then(response => {
                    this.messages = response.data;
                });
        },
        sendMessage() {
            if (this.newMessage.trim() === '') return;
            axios.post('/api/send-message', {
                to_user_id: this.$route.params.userId,
                message: this.newMessage
            }).then(() => {
                this.newMessage = '';
            });
        }
    }
};
</script>
