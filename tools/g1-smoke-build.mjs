// Intentionally deterministic Node capability check for a disposable fixture.
// No network access, dependency install, artifact write, or production use.
import { readFileSync } from 'node:fs';
import { resolve } from 'node:path';

const source = readFileSync(
  resolve('web/modules/custom/pcp_f2_fixture/src/WindowOverlapDetector.php'),
  'utf8',
);
if (!source.includes('class WindowOverlapDetector')) {
  throw new Error('G1 smoke fixture PHP source missing');
}
process.stdout.write('G1_NODE_BUILD_CHECK=PASS\n');
