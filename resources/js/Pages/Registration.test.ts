import { afterEach, describe, expect, test, vi } from 'vitest'
import { cleanup, fireEvent, render, screen } from '@testing-library/vue'
import Registration from './Registration.vue'

describe('Registration component', () => {
    afterEach(() => {
        cleanup()
    })

    test('does not allow to do submit until the fields are filled', async () => {
        const mockSubmit = vi.fn()
        render(Registration, { global: { mocks: { submit: mockSubmit } } })
        const submitButton = screen.getByText(/sign up/i)
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const nameInput = screen.getByLabelText(/name/i)
        await fireEvent.update(nameInput, 'John Doe')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const emailInput = screen.getByLabelText(/email/i)
        await fireEvent.update(emailInput, 'test@example.com')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const passwordInput = screen.getByLabelText(/^password/i)
        await fireEvent.update(passwordInput, 'password')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const passwordConfirmationInput = screen.getByLabelText(/confirm password/i)
        await fireEvent.update(passwordConfirmationInput, 'password_confirmation')
        await fireEvent.click(submitButton)
        expect(mockSubmit).toHaveBeenCalled()
    })
})
