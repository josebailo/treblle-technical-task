import { afterEach, describe, expect, test, vi } from 'vitest'
import { cleanup, fireEvent, render, screen } from '@testing-library/vue'
import SignUp from './SignUp.vue'

describe('SignUp component', () => {
    afterEach(() => {
        cleanup()
    })

    test('does not allow to do submit until the fields are filled', async () => {
        const mockSubmit = vi.fn()
        render(SignUp, { global: { mocks: { submit: mockSubmit } } })
        const submitButton = screen.getByRole('button')
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
