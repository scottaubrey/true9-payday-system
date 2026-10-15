import { describe, expect, it, mock } from "bun:test";
import { render, screen } from "@testing-library/react";
import userEvent from "@testing-library/user-event";
import { PaydayForm, PaydayFormTestIds } from "./PaydayForm";

const paydayApiClientMock = mock((_year: string, _month: string) =>
  Promise.resolve({
    success: true as const,
    data: { payDate: new Date(), paymentDate: new Date() },
  }),
);
mock.module("../api-client.ts", () => ({
  ApiClient: {
    payday: paydayApiClientMock,
  },
}));

describe("PaydayForm", () => {
  it("Shows a month field", () => {
    render(<PaydayForm />);

    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    expect(monthField).toBeVisible();
  });

  it("Shows a year field", () => {
    render(<PaydayForm />);

    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    expect(yearField).toBeVisible();
  });

  it("Shows a submit button", () => {
    render(<PaydayForm />);

    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);
    expect(submitButton).toBeVisible();
  });

  it("Retrieves data from the API when the submit button is pressed", async () => {
    const user = userEvent.setup();
    const { ApiClient } = await import("../api-client.ts");
    render(<PaydayForm />);

    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);

    await user.selectOptions(monthField, "1");
    await user.clear(yearField);
    await user.type(yearField, "2026");
    await user.click(submitButton);

    expect(ApiClient.payday).toHaveBeenCalledWith("2026", "1");
  });

  it.failing("Shows the pay and payment date on success", async () => {
    const user = userEvent.setup();
    render(<PaydayForm />);
    paydayApiClientMock.mockResolvedValueOnce({
      success: true,
      data: {
        payDate: new Date("2026-01-30"),
        paymentDate: new Date("2026-01-26"),
      },
    });

    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);

    await user.selectOptions(monthField, "1");
    await user.clear(yearField);
    await user.type(yearField, "2026");
    await user.click(submitButton);

    expect(
      screen.getByTestId(PaydayFormTestIds.payDateResult),
    ).toHaveTextContent("Fri Jan 30 2026");
  });
  it.todo("Shows an error message on failure");
});
