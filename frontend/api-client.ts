type ErrorResponse = {
  success: false;
  error: string;
};
type SuccessResponse<ViewType> = { success: true; data: ViewType };
type Response<ViewType> = SuccessResponse<ViewType> | ErrorResponse;

type PayDayView = {
  payDate: Date;
  paymentDate: Date;
};

const isValidPayDayView = (
  data: unknown,
): data is { payDate: string; paymentDate: string } => {
  if (typeof data !== "object") {
    return false;
  }

  if (data === null) {
    return false;
  }

  if (!("payDate" in data) || !("paymentDate" in data)) {
    return false;
  }

  if (
    typeof data.payDate !== "string" ||
    typeof data.paymentDate !== "string"
  ) {
    return false;
  }

  return true;
};

export const ApiClient = {
  payday: async (
    _year: string,
    _month: string,
  ): Promise<Response<PayDayView>> => {
    const response = await fetch("/api/payday");
    const data = await response.json();
    if (response.status !== 200) {
      return {
        success: false,
        error: data.message,
      };
    }

    if (!isValidPayDayView(data)) {
      console.log("Validation");
      return {
        success: false,
        error: "Validation error",
      };
    }

    return {
      success: true,
      data: {
        payDate: new Date(data.payDate),
        paymentDate: new Date(data.paymentDate),
      },
    };
  },
};
