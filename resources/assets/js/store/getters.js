export default {
    isUnlocked: state => {
        return state.isUnlocked;
    },
    isLocked: state => {
        return !state.isUnlocked
    }
}