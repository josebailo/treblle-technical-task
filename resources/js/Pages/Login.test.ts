import { afterEach, describe, expect, test, vi } from 'vitest'
import { cleanup, fireEvent, render, screen } from '@testing-library/vue'
import Login from './Login.vue'

describe('Login component', () => {
    afterEach(() => {
        cleanup()
    })

    test('does not allow to do submit until the fields are filled', async () => {
        const mockSubmit = vi.fn()
        render(Login, { global: { mocks: { submit: mockSubmit } } })
        const submitButton = screen.getByText(/log in/i)
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const emailInput = screen.getByLabelText(/email/i)
        await fireEvent.update(emailInput, 'test@example.com')
        await fireEvent.click(submitButton)
        expect(mockSubmit).not.toHaveBeenCalled()

        const passwordInput = screen.getByLabelText(/password/i)
        await fireEvent.update(passwordInput, 'password')
        await fireEvent.click(submitButton)
        expect(mockSubmit).toHaveBeenCalled()
    })
})
