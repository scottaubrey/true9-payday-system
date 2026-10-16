import { afterAll, beforeEach, describe, expect, it, spyOn } from "bun:test";
import { ApiClient } from "./api-client";

const spyFetch = spyOn(globalThis, "fetch");

describe("ApiClient", () => {
  beforeEach(() => {
    spyFetch.mockReset();
  });

  afterAll(() => {
    spyFetch.mockRestore();
  });

  describe("payday", () => {
    it("fetches from the API", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response(`{"payDate":"2026-10-30","paymentDate":"2026-10-26"}`),
      );

      await ApiClient.payday("2026", "10");
      expect(spyFetch).toHaveBeenCalled();
    });

    it("passes the given year and month as query params", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response(`{"payDate":"2026-10-30","paymentDate":"2026-10-26"}`),
      );

      await ApiClient.payday("2026", "10");

      const lastFetchCallUrl = spyFetch.mock.calls[0]?.[0];
      if (!(lastFetchCallUrl instanceof URL)) {
        expect().fail();
        return;
      }
      expect(lastFetchCallUrl.searchParams.get("year")).toEqual("2026");
      expect(lastFetchCallUrl.searchParams.get("month")).toEqual("10");
    });

    it.failing("passes and accept header of application/json", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response(`{"payDate":"2026-10-30","paymentDate":"2026-10-26"}`),
      );

      await ApiClient.payday("2026", "10");

      const requestInit = spyFetch.mock.calls[0]?.[1];
      if (!requestInit || requestInit.headers === undefined) {
        expect().fail();
        return;
      }
      const headers = new Headers(requestInit.headers);
      expect(headers.get("accept")).toEqual("application/json");
    });

    it("returns a success object for the payday view", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response('{"payDate":"2026-10-30","paymentDate":"2026-10-26"}'),
      );

      const response = await ApiClient.payday("2026", "10");

      if (!response.success) {
        expect().fail();
        return;
      }
      expect(response.data).toEqual({
        payDate: new Date("2026-10-30"),
        paymentDate: new Date("2026-10-26"),
      });
    });

    it("returns a error object when the api fails", async () => {
      spyFetch.mockResolvedValueOnce(
        new Response(`{"message":"An error occurred"}`, {
          status: 400,
        }),
      );

      const response = await ApiClient.payday("2026", "10");

      if (response.success) {
        expect().fail();
        return;
      }

      expect(response.error).toBe("An error occurred");
    });

    it("returns a error object when the data structure is incorrect", async () => {
      spyFetch.mockResolvedValueOnce(new Response(`{"random":"data"}`));

      const response = await ApiClient.payday("2026", "10");

      if (response.success) {
        expect().fail();
        return;
      }

      expect(response.error).toBe("Validation error");
    });

    it("returns a error object when the return data is not JSON", async () => {
      spyFetch.mockResolvedValueOnce(new Response(`This is not JSON`));

      const response = await ApiClient.payday("2026", "10");

      if (response.success) {
        expect().fail();
        return;
      }

      expect(response.error).toBe("Validation error");
    });

    it("returns a error object when the promise is rejected", async () => {
      spyFetch.mockRejectedValueOnce("");

      const response = await ApiClient.payday("2026", "10");

      if (response.success) {
        expect().fail();
        return;
      }

      expect(response.error).toBe("Network error");
    });
  });
});
