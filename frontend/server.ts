import index from "./index.html";

const API_TARGET = "http://localhost:8888/";
const BACKEND_READY_TIMEOUT_MS = 120000;

// run and cleanup PHP API server
const phpServer = Bun.spawn(["mise", "start-backend"], {
  stdout: "inherit",
  stderr: "inherit",
});
process.on("SIGINT", () => {
  phpServer.kill();
  process.exit(0);
});

const server = Bun.serve({
  routes: {
    "/": index,
    "/api/*": (req) => {
      const url = new URL(req.url);
      const targetUrl = `${API_TARGET}${url.pathname}${url.search}`;

      return fetch(targetUrl, req);
    },
  },
  development: true,
});

console.log(
  `Frontend server running at ${server.url} - waiting for PHP backend...`,
);

const waitForBackend = async (timeout: number): Promise<boolean> => {
  const deadline = Date.now() + timeout;
  for (;;) {
    try {
      await fetch(API_TARGET);
      return true;
    } catch {
      // Connection refused - the backend is not up yet ignore
    }
    if (Date.now() >= deadline) {
      return false;
    }
    await Bun.sleep(500);
  }
};

if (!(await waitForBackend(BACKEND_READY_TIMEOUT_MS))) {
  console.error(
    `PHP backend at ${API_TARGET} was not ready within ${BACKEND_READY_TIMEOUT_MS / 1000}s`,
  );
  process.exit(1);
}

console.log(`All servers ready - visit ${server.url}`);
