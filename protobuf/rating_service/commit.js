#!/usr/bin/env node
"use strict";

const util = require("util");
const exec = util.promisify(require("child_process").exec);
const spawn = require("child_process").spawnSync;

async function branch() {
  const { stdout, stderr } = await exec(`git rev-parse --abbrev-ref HEAD`);
  if (stderr) throw stderr;
  return stdout;
}

async function bumpVersion() {
  const npmPackageCwd = "./src/ts/";
  const currentBranch = await branch();
  const version = currentBranch.split("/").pop();

  spawn("git", ["commit", "-m", gitMessage.trim()], {
    stdio: "inherit",
  });
  spawn("git", ["tag", "-a", version], {
    stdio: "inherit",
  });

  const { stdout, stderr } = spawn(`npm version from-git`, {
    cwd: npmPackageCwd,
  });
  if (stderr) throw stderr;
  console.log(`NPM Version: ${stdout.trim()}`);

  spawn("git", ["status"], { stdio: "inherit" });

  spawn("git", ["push", "origin", currentBranch.trim()], {
    stdio: "inherit",
  });
  spawn("git", ["push", "origin", version], {
    stdio: "inherit",
  });
}

function addGeneratedFilesToStaging() {
  const npmPackageCwd = "./src/ts/";
  const phpPackageCwd = "./src/php/";
  spawn("git", ["add", "./"], {
    stdio: "inherit",
    cwd: npmPackageCwd,
  });
  spawn("git", ["add", "./"], {
    stdio: "inherit",
    cwd: phpPackageCwd,
  });
}

// TODO:
// async function bumpComposerVersion(versionType) {
//   const composer_package_cwd = "./src/php/";
//   const { stdout, stderr } = await spawn(
//     `composer config minimum-stability dev`,
//     { cwd: composer_package_cwd },
//   );
//   if (stderr) throw stderr;
//   const composer_version = stdout;
//   await spawn("git", ["add", "composer.json", "composer.lock"], {
//     stdio: "inherit",
//   });
//   await spawn("git", ["commit", "-m", gitMessage.trim()], {
//     stdio: "inherit",
//   });
//   await spawn("git", ["tag", npmVersion.trim()], { stdio: "inherit" });
//   await spawn("git", ["status"], { stdio: "inherit" });
//   const currentBranch = await branch();
//   spawn("git", ["push", "origin", currentBranch.trim()], {
//     stdio: "inherit",
//   });
// }

async function addProtobufFilesToStaging() {
  const protoFilesCwd = "./proto/";
  spawn("git", ["add", "./"], { stdio: "inherit", cwd: protoFilesCwd });
}

function generateCode() {
  const generate_code_cwd = "./";
  spawn("buf", ["generate"], {
    cwd: generate_code_cwd,
    stdio: "inherit",
  });
}

const run = async () => {
  try {
    const gitMessage = process.argv[2];
    if (!gitMessage)
      throw new Error("You need to provide a git commit message!");

    addProtobufFilesToStaging();
    generateCode();
    addGeneratedFilesToStaging();
    await bumpVersion();
  } catch (err) {
    console.log("Something went wrong:");
    console.error(JSON.stringify(err));
    console.error('\nPlease use this format: \nnode commit "Commit message"');
  }
};

run();
