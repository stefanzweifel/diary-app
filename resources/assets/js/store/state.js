export default {

    hasMasterPassword: false,
    isUnlocked: false,

    // The Entry the user is currently working with
    entry: null,

    // Encryption Password / Key
    encryption_password: null,

    // All journals
    journals: null,
    selected_journal: null,

    // Entries for the current journal
    entries: null,
    selected_entry: null,

    // The logged in User
    user: null,

    files: []
}