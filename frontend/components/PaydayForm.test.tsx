import { describe, it, expect } from "bun:test";
import { render, screen } from "@testing-library/react";
import { PaydayForm } from "./PaydayForm";

describe("PaydayForm", () => {
  it("Shows a month field", () => {
    render(<PaydayForm />);

    const monthField = screen.getByTestId("PaydayForm.month");
    expect(monthField).toBeTruthy();
  });
  it("Shows a year field", () => {
    render(<PaydayForm />);

    const yearField = screen.getByTestId("PaydayForm.year");
    expect(yearField).toBeTruthy();
  });
  it.todo("Shows a submit button");
  it.todo("Retrieves data from the API");
  it.todo("Shows the pay and payment date on success");
  it.todo("Shows an error message on failure");
});
