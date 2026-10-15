import { describe, expect, it } from "bun:test";
import { render, screen } from "@testing-library/react";
import { PaydayForm, PaydayFormTestIds } from "./PaydayForm";

describe("PaydayForm", () => {
  it("Shows a month field", () => {
    render(<PaydayForm />);

    const monthField = screen.getByTestId(PaydayFormTestIds.month);
    expect(monthField).toBeTruthy();
  });

  it("Shows a year field", () => {
    render(<PaydayForm />);

    const yearField = screen.getByTestId(PaydayFormTestIds.year);
    expect(yearField).toBeTruthy();
  });

  it("Shows a submit button", () => {
    render(<PaydayForm />);

    const submitButton = screen.getByTestId(PaydayFormTestIds.submitButton);
    expect(submitButton).toBeTruthy();
  });

  it.todo("Retrieves data from the API");
  it.todo("Shows the pay and payment date on success");
  it.todo("Shows an error message on failure");
});
